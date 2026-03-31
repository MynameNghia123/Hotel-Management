<?php

use Illuminate\Support\Facades\Route;
//client
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
//admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.auth.login');
    })->name('login');

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    // Vận hành
    Route::get('/room-map', function () {
        return view('admin.room-map.index');
    })->name('room-map.index');
    Route::get('/room-map-edit', function () {
        return view('admin.room-map-edit.index');
    })->name('room-map-edit.index');

    // Đặt phòng
    Route::get('/bookings', function () {
        return view('admin.bookings.index');
    })->name('bookings');

    // Quản lý phòng
    Route::get('/rooms', function () {
        return view('admin.rooms.index');
    })->name('rooms.index');
    Route::get('/room-types', function () {
        return view('admin.room-types.index');
    })->name('room-types.index');

    // Quản lý tài sản
    Route::get('/equipment', function () {
        return view('admin.equipment.index');
    })->name('equipment.index');
    Route::get('/equipment-types', function () {
        return view('admin.equipment-types.index');
    })->name('equipment-types.index');
    Route::get('/repair-ticket', function () {
        return view('admin.repair-ticket.index');
    })->name('repair-ticket.index');

    // Khách hàng
    Route::get('/customers', function () {
        return view('admin.customers.index');
    })->name('customers');

    // Dịch vụ & Tiện ích
    Route::get('/services', function () {
        return view('admin.services.index');
    })->name('services');
    Route::get('/service-types', function () {
        return view('admin.service-types.index');
    })->name('service-types.index');
    Route::get('/amenities', function () {
        return view('admin.amenities.index');
    })->name('amenities');

    // Hệ thống
    Route::get('/roles', function () {
        return view('admin.roles.index');
    })->name('roles');
// vai tro
    Route::get('/staff-roles', function () {
        return view('admin.staff-roles.index');
    })->name('staff-roles.index');
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings');
    Route::get('/statistical', function () {
        return view('admin.statistical.index');
    })->name('statistical');
});

Route::get('/welcome', function () {
    return view('welcome');
});