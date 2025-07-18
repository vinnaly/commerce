<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $selectedItemIds = $request->input('selected_items', []);

        $cartItems = auth()->user()->cartItems()
            ->whereIn('id', $selectedItemIds)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item yang dipilih.');
        }

        $totalWeight = $cartItems->sum(function ($item) {
            $weight = $item->product->weight ?? 500;
            return $weight * $item->quantity;
        });

        $user = auth()->user()->load('addresses');
        return view('frontend.product.checkout', compact('user', 'cartItems', 'totalWeight'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|in:midtrans,cod',
            'terms' => 'accepted',
            'selected_items' => 'required|array',
        ]);

        $user = auth()->user();
        $selectedItemIds = $request->input('selected_items', []);

        $cartItems = $user->cartItems()
            ->whereIn('id', $selectedItemIds)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan atau tidak dipilih.');
        }

        $address = $user->addresses()->findOrFail($request->address_id);
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        list($shippingMethod, $shippingCost) = explode(':', $request->shipping_method);
        $shippingCost = (int) $shippingCost;

        $grandTotal = $total + $shippingCost;
        $midtransOrderId = $user->id . '-' . time();

        $order = $user->orders()->create([
            'name' => $user->name,
            'phone' => $user->phone,
            'address' => $address->address,
            'total' => $grandTotal,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_method' => $shippingMethod,
            'shipping_cost' => $shippingCost,
            'midtrans_order_id' => $midtransOrderId,
        ]);

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->product->decrement('stock', $item->quantity);
            $item->delete();
        }

        if ($request->payment_method === 'midtrans') {
            try {
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$isProduction = config('services.midtrans.is_production');
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $midtransOrderId,
                        'gross_amount' => $grandTotal,
                    ],
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'billing_address' => [
                            'address' => $address->address,
                            'city' => $address->city ?? 'Unknown',
                            'postal_code' => $address->zip ?? '00000',
                            'country_code' => 'IDN',
                        ],
                    ],
                    'item_details' => $cartItems->map(function ($item) {
                        return [
                            'id' => $item->product_id,
                            'price' => $item->product->price,
                            'quantity' => $item->quantity,
                            'name' => $item->product->name,
                        ];
                    })->toArray(),
                    'callbacks' => [
                        'finish' => route('payment.finish'),
                        'unfinish' => route('payment.unfinish'),
                        'error' => route('payment.error'),
                    ]
                ];

                $params['item_details'][] = [
                    'id' => 'SHIPPING',
                    'price' => $shippingCost,
                    'quantity' => 1,
                    'name' => 'Biaya Pengiriman (' . strtoupper($shippingMethod) . ')',
                ];

                $snap = Snap::createTransaction($params);
                $paymentUrl = $snap->redirect_url;

                $order->update([
                    'snap_token' => $snap->token,
                    'payment_url' => $paymentUrl,
                ]);

                return redirect($paymentUrl);
            } catch (\Exception $e) {
                Log::error('Midtrans Error: ' . $e->getMessage());
                return back()->with('error', 'Gagal terhubung ke Midtrans.');
            }
        }

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function midtransCallback(Request $request)
    {
        try {
            $serverKey = config('services.midtrans.server_key');

            $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashed == $request->signature_key) {
                $order = Order::where('midtrans_order_id', $request->order_id)->first();

                if (!$order) {
                    Log::error('Order not found for Midtrans callback: ' . $request->order_id);
                    return response()->json(['message' => 'Order not found'], 404);
                }

                if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                    $order->update([
                        'status' => 'paid',
                        'payment_status' => 'paid'
                    ]);
                } elseif ($request->transaction_status == 'pending') {
                    $order->update([
                        'status' => 'pending',
                        'payment_status' => 'pending'
                    ]);
                } elseif (in_array($request->transaction_status, ['deny', 'expire', 'cancel'])) {
                    $order->update([
                        'status' => 'cancelled',
                        'payment_status' => 'failed'
                    ]);
                }

                Log::info('Midtrans callback processed successfully for order: ' . $request->order_id);
                return response()->json(['message' => 'Callback processed successfully'], 200);
            } else {
                Log::error('Invalid signature for Midtrans callback');
                return response()->json(['message' => 'Invalid signature'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage());
            return response()->json(['message' => 'Callback error'], 500);
        }
    }

    public function redirectToMidtrans(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_method !== 'midtrans' || $order->status !== 'pending' || !$order->payment_url) {
            return back()->with('error', 'Pembayaran tidak tersedia untuk pesanan ini.');
        }

        return redirect($order->payment_url);
    }

    public function paymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');

        if ($orderId) {
            $order = Order::where('midtrans_order_id', $orderId)->first();

            if ($order) {
                if ($order->status === 'pending') {
                    $order->update([
                        'status' => 'paid',
                        'payment_status' => 'paid'
                    ]);
                }
            }
        }

        return redirect()->route('account.index')->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    public function paymentUnfinish(Request $request)
    {
        $orderId = $request->query('order_id');

        return redirect()->route('account.index')->with('info', 'Pembayaran belum selesai. Silahkan selesaikan pembayaran Anda.');
    }

    public function paymentError(Request $request)
    {
        $orderId = $request->query('order_id');

        if ($orderId) {
            $order = Order::where('midtrans_order_id', $orderId)->first();

            if ($order && $order->status === 'pending') {
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed'
                ]);
            }
        }

        return redirect()->route('account.index')->with('error', 'Pembayaran gagal. Silahkan coba lagi atau hubungi customer service.');
    }
}