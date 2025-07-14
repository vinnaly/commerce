{{-- resources/views/frontend/account/orders.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<section class="section-margin--small">
  <div class="container">
    <h3 class="mb-4">Pesanan Saya</h3>

    @forelse($orders as $order)
      <div class="card mb-3">
        <div class="card-body">
          <h5>Pesanan #{{ $order->id }} - {{ $order->created_at->format('d M Y') }}</h5>
          <p>Status: <strong>{{ ucfirst($order->status) }}</strong></p>
          <p>Metode Pembayaran: <strong>{{ strtoupper($order->payment_method) }}</strong></p>
          <ul>
            @foreach($order->orderItems as $item)
              <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
            @endforeach
          </ul>

          {{-- Tombol Bayar jika status pending dan metode midtrans --}}
          @if(
              $order->payment_method === 'midtrans' &&
              $order->status === 'pending' &&
              $order->payment_status !== 'paid' &&
              $order->snap_token &&
              $order->payment_url
          )
            <form action="{{ route('midtrans.redirect', $order->id) }}" method="POST" class="mt-2">
              @csrf
              <button type="submit" class="btn btn-sm btn-warning">Bayar Sekarang</button>
            </form>
          @endif

          {{-- Tombol pesanan selesai --}}
          @if($order->status === 'paid')
            <form action="{{ route('account.orders.complete', $order->id) }}" method="POST" class="mt-2">
              @csrf
              <button class="btn btn-sm btn-success">Pesanan Selesai</button>
            </form>
          @endif
        </div>
      </div>
    @empty
      <p>Tidak ada pesanan aktif.</p>
    @endforelse
  </div>
</section>
@endsection
