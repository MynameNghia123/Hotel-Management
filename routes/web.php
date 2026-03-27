<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('client.pages.homepage');
})->name('home');

Route::get('/gallery', function () {
    return view('client.pages.gallery');
})->name('gallery');
Route::get('/amenities', function() {
    return view('client.pages.amenities');
})->name('amenities');
Route::get('/dining', function() {
    return view('client.pages.dining');
})->name('dining');
Route::get('/register', function() {
    return view('client.auth.register');
})->name('register');
Route::get('/login', function() {
    return view('client.auth.login');
})->name('login');
