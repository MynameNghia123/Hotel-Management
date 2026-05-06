<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomMapController;
use App\Http\Controllers\RoomMapEditController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomTypeActionController;
use App\Http\Controllers\ServiceGroupController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\RepairTicketController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\StatisticalController;
use App\Http\Middleware\CheckAdminPermission;

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
    Route::get('/', [RoomMapController::class, 'index'])->name('index');
    Route::get('/index', [RoomMapController::class, 'index']);

    Route::get('/detail/{id?}', [RoomMapController::class, 'detail'])->name('detail');
    Route::get('/available-detail/{id?}', [RoomMapController::class, 'availableDetail'])->name('available-detail');
    Route::get('/incoming-detail/{id?}', [RoomMapController::class, 'incomingDetail'])->name('incoming-detail');
    Route::patch('/rooms/{id}/status', [RoomMapController::class, 'updateRoomStatus'])->name('room-status');
    Route::post('/incoming-detail/{id}/cancel', [RoomMapController::class, 'cancelIncomingBooking'])->name('incoming-cancel');
    Route::post('/incoming-detail/{id}/checkin', [RoomMapController::class, 'checkInIncomingBooking'])->name('incoming-checkin');
    Route::post('/detail/{id}/add-service', [RoomMapController::class, 'addCheckoutService'])->name('detail-add-service');
    Route::post('/detail/{id}/checkout-preview', [RoomMapController::class, 'previewCheckoutSelectedRooms'])->name('detail-checkout-preview');
    Route::post('/detail/{id}/checkout-selected', [RoomMapController::class, 'checkoutSelectedRooms'])->name('detail-checkout-selected');
    Route::get('/invoice', [RoomMapController::class, 'invoice'])->name('invoice');
});

// ============== Vận hành - Room Map Edit ==============

Route::group(['prefix' => 'room-map-edit', 'as' => 'room-map-edit.'], function () {
    Route::get('/', [RoomMapEditController::class, 'index'])->name('index');
    
    // For RoomType (currently redirecting or handling within RoomController, but we use this view or logic)
    // If it's a separate view:
    Route::get('/create-type', [RoomTypeController::class, 'create'])->name('create-type'); // Adjust if you want specific view

    // Floors
    Route::get('/create-floor', [RoomMapEditController::class, 'createFloor'])->name('create-floor');
    Route::post('/floors', [RoomMapEditController::class, 'storeFloor'])->name('store-floor');
    Route::delete('/floors/{id}', [RoomMapEditController::class, 'destroyFloor'])->name('destroy-floor');

    // Rooms
    Route::get('/create-room', [RoomMapEditController::class, 'createRoom'])->name('create-room');
    Route::post('/rooms', [RoomMapEditController::class, 'storeRoom'])->name('store-room');
    Route::delete('/rooms/{id}', [RoomMapEditController::class, 'destroyRoom'])->name('destroy-room');
});

// ============== Đặt phòng ==============
Route::group(['prefix' => 'bookings', 'as' => 'bookings.'], function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::get('/{id}', [BookingController::class, 'show'])->name('show');
    Route::patch('/{id}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');
});

// ============== Quản lý phòng ==============
Route::group(['prefix' => 'rooms', 'as' => 'rooms.'], function () {
    // Web routes - HTML pages
    Route::get('/', [RoomTypeController::class, 'index'])->name('index');
    Route::get('/create', [RoomTypeController::class, 'create'])->name('create');
    Route::post('/', [RoomTypeController::class, 'store'])->name('store');
    Route::get('/{id}', [RoomTypeController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [RoomTypeController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RoomTypeController::class, 'update'])->name('update');
    Route::delete('/{id}', [RoomTypeController::class, 'destroy'])->name('destroy');
    
    // AJAX/API endpoints
    Route::post('/temp-images/upload', [RoomTypeActionController::class, 'uploadTempImage'])->name('temp-images.upload');
    Route::delete('/temp-images/delete', [RoomTypeActionController::class, 'deleteTempImage'])->name('temp-images.delete');
    Route::post('/{id}/images', [RoomTypeActionController::class, 'uploadImage'])->name('images.upload');
    Route::delete('/{id}/images/{imageId}', [RoomTypeActionController::class, 'deleteImage'])->name('images.delete');
    Route::post('/{id}/amenities/sync', [RoomTypeActionController::class, 'syncAmenities'])->name('amenities.sync');
    Route::post('/{id}/equipments/sync', [RoomTypeActionController::class, 'syncEquipments'])->name('equipments.sync');
});



// ============== Quản lý tài sản ==============
Route::group(['prefix' => 'equipment', 'as' => 'equipment.'], function () {
    Route::get('/', [EquipmentController::class, 'index'])->name('index');
    Route::get('/create', [EquipmentController::class, 'create'])->name('create');
    Route::post('/', [EquipmentController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EquipmentController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EquipmentController::class, 'update'])->name('update');
    Route::delete('/{id}', [EquipmentController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'equipment-types', 'as' => 'equipment-types.'], function () {
    Route::get('/', [EquipmentCategoryController::class, 'index'])->name('index');
    Route::get('/create', [EquipmentCategoryController::class, 'create'])->name('create');
    Route::post('/', [EquipmentCategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EquipmentCategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EquipmentCategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [EquipmentCategoryController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'repair-ticket', 'as' => 'repair-ticket.'], function () {
    Route::get('/', [RepairTicketController::class, 'index'])->name('index');
    Route::get('/create', [RepairTicketController::class, 'create'])->name('create');
    Route::post('/', [RepairTicketController::class, 'store'])->name('store');
    Route::get('/{id}', [RepairTicketController::class, 'show'])->name('show');
    Route::patch('/{id}/status', [RepairTicketController::class, 'updateStatus'])->name('updateStatus');
});

// ============== Khách hàng ==============
Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
});


// ============== Dịch vụ & Tiện ích ==============
Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
     Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/create', [ServiceController::class, 'create'])->name('create');
    Route::post('/', [ServiceController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ServiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'service-types', 'as' => 'service-types.'], function () {
    Route::get('/', [ServiceGroupController::class, 'index'])->name('index');
    Route::get('/create', [ServiceGroupController::class, 'create'])->name('create');
    Route::post('/', [ServiceGroupController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ServiceGroupController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ServiceGroupController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServiceGroupController::class, 'destroy'])->name('destroy');
});



Route::group(['prefix' => 'amenities', 'as' => 'amenities.'], function () {
    Route::get('/', [AmenityController::class, 'index'])->name('index');
    Route::get('/create', [AmenityController::class, 'create'])->name('create');
    Route::post('/', [AmenityController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AmenityController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AmenityController::class, 'update'])->name('update');
    Route::delete('/{id}', [AmenityController::class, 'destroy'])->name('destroy');
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
    Route::get('/', [ConfigurationController::class, 'index'])->name('index');
    Route::post('/general', [ConfigurationController::class, 'updateGeneralSettings'])->name('update-general');
    Route::post('/surcharges', [ConfigurationController::class, 'updateSurchargePolicies'])->name('update-surcharges');
});

// ============== Thống kê ==============
Route::group(['prefix' => 'statistical', 'as' => 'statistical.'], function () {
    Route::get('/', [StatisticalController::class, 'index'])->name('index');
    Route::get('/revenue', [StatisticalController::class, 'revenue'])->name('revenue');
    Route::get('/room-efficiency', [StatisticalController::class, 'roomEfficiency'])->name('room-efficiency');
    Route::get('/customers', [StatisticalController::class, 'customers'])->name('customers');
});

}); // Close protected routes middleware group
