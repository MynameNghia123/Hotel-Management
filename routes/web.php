<?php

use Illuminate\Support\Facades\Route;


// Client routes
require __DIR__.'/client.php';

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/admin.php';
});

// Welcome route
Route::get('/welcome', function () {
    return view('welcome');
});