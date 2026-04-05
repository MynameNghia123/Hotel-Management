<?php

use Illuminate\Support\Facades\Route;

// ============== Auth & Dashboard ==============
Route::get('/', function () {
    return redirect(route('admin.login'));
});

Route::get('/login', function () {
    return view('admin.auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');

// ============== Vận hành - Room Map ==============
Route::group(['prefix' => 'room-map', 'as' => 'room-map.'], function () {
    Route::get('/', function () {
        return view('admin.room-map.index');
    })->name('index');

    Route::get('/detail', function () {
        return view('admin.room-map.detail');
    })->name('detail');

    Route::post('/detail/add-service', function () {
        return response()->json(['message' => 'Service added successfully (Mock)']);
    })->name('add-service');

    Route::get('/invoice', function () {
        return view('admin.room-map.invoice');
    })->name('invoice');

    Route::get('/incoming', function () {
        return view('admin.room-map.incoming-detail');
    })->name('incoming');

    Route::get('/available', function () {
        return view('admin.room-map.available-detail');
    })->name('available');
});

// ============== Vận hành - Room Map Edit ==============
Route::group(['prefix' => 'room-map-edit', 'as' => 'room-map-edit.'], function () {
    Route::get('/', function () {
        return view('admin.room-map-edit.index');
    })->name('index');

    Route::get('/create-type', function () {
        return view('admin.room-map-edit.create-type');
    })->name('create-type');

    Route::get('/create-floor', function () {
        return view('admin.room-map-edit.create-floor');
    })->name('create-floor');

    Route::get('/create-room', function () {
        return view('admin.room-map-edit.create-room');
    })->name('create-room');
});

// ============== Đặt phòng ==============
Route::group(['prefix' => 'bookings', 'as' => 'bookings.'], function () {
    Route::get('/', function () {
        return view('admin.bookings.index');
    })->name('index');

    Route::get('/create', function () {
        return view('admin.bookings.create');
    })->name('create');
});

// ============== Quản lý phòng ==============
Route::group(['prefix' => 'rooms', 'as' => 'rooms.'], function () {
    Route::get('/', function () {
        return view('admin.rooms.index');
    })->name('index');
});

Route::group(['prefix' => 'room-types', 'as' => 'room-types.'], function () {
    Route::get('/', function () {
        return view('admin.room-types.index');
    })->name('index');

    Route::get('/edit', function () {
        return view('admin.room-types.edit');
    })->name('edit');
});

// ============== Quản lý tài sản ==============
Route::group(['prefix' => 'equipment', 'as' => 'equipment.'], function () {
    Route::get('/', function () {
        return view('admin.equipment.index');
    })->name('index');

    Route::get('/edit', function () {
        return view('admin.equipment.edit');
    })->name('edit');
});

Route::group(['prefix' => 'equipment-types', 'as' => 'equipment-types.'], function () {
    Route::get('/', function () {
        return view('admin.equipment-types.index');
    })->name('index');
});

Route::group(['prefix' => 'repair-ticket', 'as' => 'repair-ticket.'], function () {
    Route::get('/', function () {
        return view('admin.repair-ticket.index');
    })->name('index');

    Route::get('/create', function () {
        return view('admin.repair-ticket.add');
    })->name('create');

    Route::get('/detail', function () {
        return view('admin.repair-ticket.detail');
    })->name('detail');
});

// ============== Khách hàng ==============
Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
    Route::get('/', function () {
        return view('admin.customers.index');
    })->name('index');

    Route::get('/create', function() {
        return view('admin.customers.create');   
    })->name('create');

    Route::get('/edit', function() {
        return view('admin.customers.edit');   
    })->name('edit');
});

// ============== Dịch vụ & Tiện ích ==============
Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
    Route::get('/', function () {
        return view('admin.services.index');
    })->name('index');
});

Route::group(['prefix' => 'service-types', 'as' => 'service-types.'], function () {
    Route::get('/', function () {
        return view('admin.service-types.index');
    })->name('index');
});

Route::group(['prefix' => 'amenities', 'as' => 'amenities.'], function () {
    Route::get('/', function () {
        return view('admin.amenities.index');
    })->name('index');
});

// ============== Hệ thống ==============
Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
    Route::get('/', function () {
        return view('admin.employees.index');
    })->name('index');
});

Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
    Route::get('/', function () {
        return view('admin.roles.index');
    })->name('index');
});

Route::group(['prefix' => 'configuration', 'as' => 'configuration.'], function () {
    Route::get('/', function () {
        return view('admin.configuration.index');
    })->name('index');
});

// ============== Thống kê ==============
Route::group(['prefix' => 'statistical', 'as' => 'statistical.'], function () {
    Route::get('/', function () {
        return view('admin.statistical.index');
    })->name('index');

    Route::get('/revenue', function () {
        return view('admin.statistical.revenue');
    })->name('revenue');

    Route::get('/room-efficiency', function () {
        return view('admin.statistical.room-efficiency');
    })->name('room-efficiency');

    Route::get('/customers', function () {
        return view('admin.statistical.customers');
    })->name('customers');
});
