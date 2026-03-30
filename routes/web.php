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
    Route::get('/rooms/map', function () {
        return view('admin.rooms.map');
    })->name('rooms.map');
    Route::get('/rooms/edit-map', function () {
        return view('admin.rooms.edit-map');
    })->name('rooms.edit-map');

    // Đặt phòng
    Route::get('/bookings', function () {
        return view('admin.bookings.index');
    })->name('bookings');

    // Quản lý phòng
    Route::get('/rooms', function () {
        return view('admin.rooms.index');
    })->name('rooms.index');
    Route::get('/rooms/types', function () {
        return view('admin.rooms.types');
    })->name('rooms.types');

    // Quản lý tài sản
    Route::get('/assets/equipment', function () {
        return view('admin.assets.equipment');
    })->name('assets.equipment');
    Route::get('/assets/groups', function () {
        return view('admin.assets.groups');
    })->name('assets.groups');
    Route::get('/assets/repairs', function () {
        return view('admin.assets.repairs');
    })->name('assets.repairs');

    // Khách hàng
    Route::get('/customers', function () {
        return view('admin.customers.index');
    })->name('customers');

    // Dịch vụ & Tiện ích
    Route::get('/services', function () {
        return view('admin.services.index');
    })->name('services');
    Route::get('/services/types', function () {
        return view('admin.services.types');
    })->name('services.types');
    Route::get('/amenities', function () {
        return view('admin.amenities.index');
    })->name('amenities');

    // Hệ thống
    Route::get('/staff', function () {
        return view('admin.staff.index');
    })->name('staff');

    Route::get('/staff/roles', function () {
        return view('admin.staff.roles');
    })->name('staff.roles');
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings');
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('reports');
});

Route::get('/welcome', function () {
    return view('welcome');
});