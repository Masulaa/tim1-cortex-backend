<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    Car\Car\AdminCarController,
    Car\Car\AdminCarStatusController,
    User\AdminUserController,
    User\AdminSetterController,
    User\AdminUserBlockController,
    Car\Reservation\AdminReservationController,
    Car\Reservation\AdminReservationStatusController
};

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::middleware(['auth', 'verified', IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/cars/status', [AdminCarStatusController::class, 'carStatus'])->name('admin.cars.status');
    Route::put('/admin/cars/{id}/status', [AdminCarStatusController::class, 'updateStatus'])->name('admin.cars.updateStatus');
    Route::get('admin/cars/{id}/rental-history', [AdminCarController::class, 'rentalHistory'])->name('admin.cars.rental-history');

    Route::resource('/admin/cars', AdminCarController::class)->names([
        'index' => 'admin.cars.index',
        'create' => 'admin.cars.create',
        'store' => 'admin.cars.store',
        'show' => 'admin.cars.show',
        'edit' => 'admin.cars.edit',
        'update' => 'admin.cars.update',
        'destroy' => 'admin.cars.destroy',
    ]);

    Route::resource('/admin/users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    Route::post('/admin/users/{id}/block', [AdminUserBlockController::class, 'block'])->name('admin.users.block');
    Route::post('/admin/users/{id}/unblock', [AdminUserBlockController::class, 'unblock'])->name('admin.users.unblock');

    Route::post('users/{id}/set-admin', [AdminSetterController::class, 'setAdmin'])->name('admin.users.setadmin');
    Route::post('users/{id}/remove-admin', [AdminSetterController::class, 'removeAdmin'])->name('admin.users.removeadmin');

    Route::get('/admin/reservations/status', [AdminReservationStatusController::class, 'reservationStatus'])->name('admin.reservations.status');
    Route::put('/admin/reservations/{id}/status', [AdminReservationStatusController::class, 'updateStatus'])->name('admin.reservations.updateStatus');

    Route::resource('admin/reservations', AdminReservationController::class)->names([
        'index' => 'admin.reservations.index',
        'create' => 'admin.reservations.create',
        'store' => 'admin.reservations.store',
        'show' => 'admin.reservations.show',
        'edit' => 'admin.reservations.edit',
        'update' => 'admin.reservations.update',
        'destroy' => 'admin.reservations.destroy',
    ]);



    Route::get('admin/reservations/{id}/invoice', [AdminReservationController::class, 'generateInvoice'])->name('admin.reservations.invoice');

});

//     Route::get('/admin', [AdminController::class, 'index'])
//    name('admin.dashboard');