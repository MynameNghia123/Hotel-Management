<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\RoomTypeApiController;

// ============== Booking API ==============
Route::prefix('bookings')->group(function () {
    Route::post('/verify-customer', [BookingApiController::class, 'verifyCustomer'])->name('api.bookings.verify-customer');
    Route::post('/available-rooms', [BookingApiController::class, 'availableRooms'])->name('api.bookings.available-rooms');
});

// ============== Room Type API ==============
Route::prefix('room-types')->group(function () {
    Route::post('/', [RoomTypeApiController::class, 'store'])->name('api.room-types.store');
});
