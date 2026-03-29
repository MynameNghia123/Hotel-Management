<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/search', function() {
    return view('client.pages.search');
})->name('search');

Route::get('/checkout', function() {
    return view('client.pages.checkout');
})->name('checkout');

Route::get('/payment', function() {
    return view('client.pages.payment');
})->name('payment');

Route::get('/success', function() {
    return view('client.pages.success');
})->name('success');

Route::get('/profile', function () {
    return view('client.pages.profile');
})->name('profile');

Route::get('/register', function () {
    return view('client.auth.register');
})->name('register');

Route::get('/login', function () {
    return view('client.auth.login');
})->name('login');

Route::get('/forgot-password', function() {
    return view('client.auth.forgot_password');
})->name('forgot_password');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/welcome', function () {
    return view('welcome');
});
