<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ServiceGroupController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentCategoryController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Middleware\CheckAdminPermission;
use App\Models\Staff;

// ============== Auth & Dashboard ==============
Route::get('/', function () {
    return redirect(route('admin.login'));
});

// Login routes (không cần middleware)
Route::get('/login', [AuthAdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthAdminController::class, 'login']);
Route::post('/logout', [AuthAdminController::class, 'logout'])->name('logout');

// Dashboard (cần quyền admin)
Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(CheckAdminPermission::class)->name('dashboard');

// ============== Protected Routes - Cần đăng nhập ==============
Route::middleware([CheckAdminPermission::class])->group(function () {

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
    Route::get('/', [RoomTypeController::class, 'index'])->name('index');
    Route::get('/create', [RoomTypeController::class, 'create'])->name('create');
    Route::post('/', [RoomTypeController::class, 'store'])->name('store');
    Route::get('/{id}', [RoomTypeController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [RoomTypeController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RoomTypeController::class, 'update'])->name('update');
    Route::delete('/{id}', [RoomTypeController::class, 'destroy'])->name('destroy');
    // AJAX endpoints
    Route::post('/{id}/images', [RoomTypeController::class, 'uploadImage'])->name('images.upload');
    Route::delete('/{id}/images/{imageId}', [RoomTypeController::class, 'deleteImage'])->name('images.delete');
    Route::post('/{id}/amenities/sync', [RoomTypeController::class, 'syncAmenities'])->name('amenities.sync');
    Route::post('/{id}/equipments/sync', [RoomTypeController::class, 'syncEquipments'])->name('equipments.sync');
});



// ============== Quản lý tài sản ==============
Route::group(['prefix' => 'equipment', 'as' => 'equipment.'], function () {
    Route::get('/', [App\Http\Controllers\EquipmentController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\EquipmentController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\EquipmentController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\EquipmentController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\EquipmentController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\EquipmentController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'equipment-types', 'as' => 'equipment-types.'], function () {
    Route::get('/', [App\Http\Controllers\EquipmentCategoryController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\EquipmentCategoryController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\EquipmentCategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\EquipmentCategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\EquipmentCategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\EquipmentCategoryController::class, 'destroy'])->name('destroy');
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
    Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\CustomerController::class, 'store'])->name('store');
    Route::get('/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('destroy');
});


// ============== Dịch vụ & Tiện ích ==============
Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
     Route::get('/', [App\Http\Controllers\ServiceController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\ServiceController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\ServiceController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\ServiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\ServiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\ServiceController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'service-types', 'as' => 'service-types.'], function () {
    Route::get('/', [App\Http\Controllers\ServiceGroupController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\ServiceGroupController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\ServiceGroupController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\ServiceGroupController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\ServiceGroupController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\ServiceGroupController::class, 'destroy'])->name('destroy');
});



Route::group(['prefix' => 'amenities', 'as' => 'amenities.'], function () {
    Route::get('/', [App\Http\Controllers\AmenityController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\AmenityController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\AmenityController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\AmenityController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\AmenityController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\AmenityController::class, 'destroy'])->name('destroy');
});

// ============== Hệ thống ==============
Route::group(['prefix' => 'staffs', 'as' => 'staffs.'], function () {
    Route::get('/', [StaffController::class, 'index'])->name('index');
    Route::get('/create', [StaffController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [StaffController::class, 'edit'])->name('edit');
    Route::post('/', [StaffController::class, 'store'])->name('store');
    Route::put('/{id}', [StaffController::class, 'update'])->name('update');
    Route::put('/{id}/toggle-status', [StaffController::class, 'toggleStatus'])->name('toggle-status');
    Route::delete('/{id}', [StaffController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::post('/', [RoleController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
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

}); // Close protected routes middleware group
