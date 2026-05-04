<?php


use App\Http\Controllers\AuthClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Đăng nhập / Đăng xuất Khách hàng (OTP)
// Gắn throttle: 3 lần / 1 phút để chống spam gửi OTP
Route::post('/login/send-otp', [AuthClientController::class, 'sendOtp'])->name('client.send_otp')->middleware('throttle:3,1');
Route::post('/login/verify-otp', [AuthClientController::class, 'verifyOtp'])->name('client.verify_otp')->middleware('throttle:10,1');
// Gắn throttle cho đăng ký: 3 lần / 1 phút (chống spam bot tạo tài khoản)
Route::post('/register', [AuthClientController::class, 'register'])->name('client.register')->middleware('throttle:3,1');
Route::post('/logout', [AuthClientController::class, 'logout'])->name('client.logout');


// Trang chủ và thông tin chung
Route::get('/', function () {
    return view('client.pages.homepage');
})->name('home');

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
Route::get('/search', function () {
    return view('client.pages.search');
})->name('search');

Route::get('/checkout', function () {
    return view('client.pages.checkout');
})->name('checkout');

Route::get('/payment', function () {
    return view('client.pages.payment');
})->name('payment');

Route::get('/success', function () {
    return view('client.pages.success');
})->name('success');

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
