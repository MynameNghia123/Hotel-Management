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

Route::get('/profile', function () {
    return view('client.pages.profile');
})->name('profile');

Route::get('/register', function () {
    return view('client.auth.register');
})->name('register');

Route::get('/login', function () {
    return view('client.auth.login');
})->name('login');

Route::get('/forgot-password', function () {
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
    })->name('bookings.index');
    Route::get('/bookings/create', function () {
        return view('admin.bookings.create');
    })->name('bookings.create');

    // Quản lý phòng
    Route::get('/rooms', function () {
        return view('admin.rooms.index');
    })->name('rooms.index');
    Route::get('/room-map/detail', function () {
        return view('admin.room-map.detail');
    })->name('room-map.detail');


    Route::post('/room-map/detail/add-service', function () {
        return response()->json(['message' => 'Service added successfully (Mock)']);
    })->name('room-map.add-service');

    // Route cho Hóa Đơn In
    Route::get('room-map/invoice', function () {
        return view('admin.room-map.invoice');
    })->name('room-map.invoice');

    // Route Chi tiết Khách Bấm Sắp Nhận (Chưa Đến)
    Route::get('room-map/incoming', function () {
        return view('admin.room-map.incoming-detail');
    })->name('room-map.incoming');

    // Route Chi tiết Phòng Trống
    Route::get('room-map/available', function () {
        return view('admin.room-map.available-detail');
    })->name('room-map.available');
    // phong trong
    Route::get('room-map/available', function () {
        return view('admin.room-map.available-detail');
    })->name('room-map.available');

    Route::get('/room-types', function () {
        return view('admin.room-types.index');
    })->name('room-types.index');
    Route::get('room-types/edit', function () {
        return view('admin.room-types.edit');
    })->name('room-types.edit');
    // Chỉnh sửa sơ đồ phòng
    Route::get('room-map-edit', function () {
        return view('admin.room-map-edit.index');
    })->name('room-map-edit.index');

    Route::get('room-map-edit/create-type', function () {
        return view('admin.room-map-edit.create-type');
    })->name('room-map-edit.create-type');

    Route::get('room-map-edit/create-floor', function () {
        return view('admin.room-map-edit.create-floor');
    })->name('room-map-edit.create-floor');

    Route::get('room-map-edit/create-room', function () {
        return view('admin.room-map-edit.create-room');
    })->name('room-map-edit.create-room');

    // Quản lý tài sản
    Route::get('/equipment', function () {
        return view('admin.equipment.index');
    })->name('equipment.index');
    Route::get('/equipment/edit', function () {
        return view('admin.equipment.edit');
    })->name('equipment.edit');
    Route::get('/equipment-types', function () {
        return view('admin.equipment-types.index');
    })->name('equipment-types.index');
    Route::get('/repair-ticket', function () {
        return view('admin.repair-ticket.index');
    })->name('repair-ticket.index');
    Route::get('/repair-ticket/create', function () {
        return view('admin.repair-ticket.add');
    })->name('repair-ticket.create');
    Route::get('/repair-ticket/detail', function () {
        return view('admin.repair-ticket.detail');
    })->name('repair-ticket.detail');

    // Khách hàng
    Route::get('/customers', function () {
        return view('admin.customers.index');
    })->name('customers');
    Route::get('customers/create', function() {
     return view('admin.customers.create');   
    })->name('customers.create');
    Route::get('customers/edit', function() {
        return view('admin.customers.edit');   
    })->name('customers.edit');

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
    Route::get('/configuration', function () {
        return view('admin.configuration.index');
    })->name('configuration.index');
    Route::get('/statistical', function () {
        return view('admin.statistical.index');
    })->name('statistical.index');
    Route::get('/statistical-revenue', function () {
        return view('admin.statistical.revenue');
    })->name('statistical.revenue');
    Route::get('statistical-room-efficiency', function () {
        return view('admin.statistical.room-efficiency');
    })->name('statistical.room-efficiency');
    Route::get('statistical-customers', function () {
        return view('/admin.statistical.customers');
    })->name('statistical.customers');
}); 

Route::get('/welcome', function () {
    return view('welcome');
});