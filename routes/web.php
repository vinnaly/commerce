<?php

use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\Frontend\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Form Registrasi
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

// Proses Registrasi (otomatis beri role 'user', redirect ke login)
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Redirect setelah login (tergantung role)
Route::middleware('auth')->get('/redirect', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect('/admin'); // Ganti sesuai route admin Filament
    }

    return redirect()->route('account.index'); // User biasa diarahkan ke dashboard
})->name('redirect');

// Dashboard user biasa (hanya bisa diakses oleh role:user)
Route::middleware(['auth', 'role:user'])->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
});


Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    // Dashboard
    Route::get('/', [AccountController::class, 'index'])->name('index');

    // Profile
    Route::post('/update-profile', [AccountController::class, 'updateProfile'])->name('update');
    Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('password');
    Route::post('/upload-picture', [AccountController::class, 'uploadPicture'])->name('picture');
    Route::delete('/delete-picture', [AccountController::class, 'deletePicture'])->name('delete-picture');

    // Address
    Route::post('/address/add', [AccountController::class, 'addAddress'])->name('address.add');
    Route::put('/address/{id}', [AccountController::class, 'updateAddress'])->name('address.update');
    Route::delete('/address/{id}', [AccountController::class, 'deleteAddress'])->name('address.delete');
    Route::get('/account/address/{id}/data', [AccountController::class, 'getAddressData'])->name('address.data');

    // Orders
    Route::get('/orders', [AccountController::class, 'ordersInProgress'])->name('orders');
    Route::get('/orders/history', [AccountController::class, 'orderHistory'])->name('orders.history');
    Route::post('/orders/{order}/complete', [AccountController::class, 'markOrderAsCompleted'])->name('orders.complete');

    // Reviews
    Route::get('/review/{order}', [AccountController::class, 'reviewForm'])->name('reviews.form');
    Route::post('/review/{order}', [AccountController::class, 'submitReview'])->name('reviews.submit');
    Route::get('/reviews', [AccountController::class, 'myReviews'])->name('reviews.list');
});


// PRODUCT COLLECTION
Route::get('/collection', [ProductController::class, 'collection'])->name('product.collection');

// FILTER BY CATEGORY
Route::get('/product/category/{slug}', [ProductController::class, 'category'])->name('product.category');

// DETAIL PRODUCT (dengan slug)
Route::get('/product/{slug}', [ProductController::class, 'detail'])->name('product.detail');

// ADD TO CART (harus login)
Route::post('/add-to-cart', [CartController::class, 'add'])->middleware('auth')->name('cart.add');

//BUY NOW
// routes/web.php
Route::post('/buy-now', [ProductController::class, 'buyNow'])->name('buy.now');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');


// HALAMAN CART
Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Midtrans
Route::get('/payment/finish', [CheckoutController::class, 'paymentFinish'])->name('payment.finish');
Route::get('/payment/unfinish', [CheckoutController::class, 'paymentUnfinish'])->name('payment.unfinish');
Route::get('/payment/error', [CheckoutController::class, 'paymentError'])->name('payment.error');
Route::post('/midtrans/pay/{order}', [CheckoutController::class, 'redirectToMidtrans'])->name('midtrans.redirect');
Route::post('/midtrans/pay/{order}', [CheckoutController::class, 'redirectToMidtrans'])->name('midtrans.redirect');



Route::prefix('api')->group(function () {

    Route::prefix('destinations')->group(function () {
        Route::get('/search', [RajaOngkirController::class, 'searchDestination']);
        Route::get('/{id}/detail', [RajaOngkirController::class, 'getDestinationDetail']);
    });

    Route::post('/cost', [RajaOngkirController::class, 'cost']);
});

require __DIR__.'/auth.php';
