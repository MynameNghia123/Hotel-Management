<?php

use App\Http\Controllers\ClientBookingController;
use App\Http\Controllers\Client\AuthClientController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\SearchController;
use Illuminate\Support\Facades\Route;

// Đăng nhập / Đăng xuất Khách hàng (OTP)
// Gắn throttle: 3 lần / 1 phút để chống spam gửi OTP
Route::post('/login/send-otp', [AuthClientController::class, 'sendOtp'])->name('client.send_otp')->middleware('throttle:3,1');
Route::post('/login/verify-otp', [AuthClientController::class, 'verifyOtp'])->name('client.verify_otp')->middleware('throttle:10,1');
// Gắn throttle cho đăng ký: 3 lần / 1 phút (chống spam bot tạo tài khoản)
Route::post('/register', [AuthClientController::class, 'register'])->name('client.register')->middleware('throttle:3,1');
Route::post('/logout', [AuthClientController::class, 'logout'])->name('client.logout');


// Trang chủ và thông tin chung
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/room', function () {
    return view('client.pages.room');
})->name('room');

Route::get('/gallery', function () {
    return view('client.pages.gallery');
})->name('gallery');

Route::get('/amenities', function () {
    return view('client.pages.amenities');
})->name('amenities');

Route::get('/dining', function () {
    return view('client.pages.dining');
})->name('dining');



// Đặt phòng
Route::get('/search', [ClientBookingController::class, 'search'])->name('search');

// Các bước checkout cần có dữ liệu truyền vào
Route::post('/checkout/init', [ClientBookingController::class, 'initCheckout'])->name('checkout.init');
Route::get('/checkout', [ClientBookingController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [ClientBookingController::class, 'store'])->name('checkout.store');

Route::get('/payment', [ClientBookingController::class, 'payment'])->name('payment');
Route::post('/payment/process', [ClientBookingController::class, 'processPayment'])->name('payment.process');
Route::get('/vnpay-return', [ClientBookingController::class, 'vnpayReturn'])->name('vnpay.return');

Route::get('/success', [ClientBookingController::class, 'success'])->name('success');

// Tài khoản khách hàng (yêu cầu đăng nhập)
Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Xác thực
Route::get('/register', function () {
    return view('client.auth.register');
})->name('register');

Route::get('/login', function () {
    return view('client.auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('client.auth.forgot_password');
})->name('forgot_password');
