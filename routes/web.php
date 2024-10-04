<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    Car\AdminCarController,
    User\AdminUserController,
    User\AdminSetterController,
};

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->middleware('auth', IsAdmin::class)->name('admin.dashboard');
    Route::resource('/admin/cars', AdminCarController::class)->names(['index' => 'admin.cars.index', 'create' => 'admin.cars.create', 'store' => 'admin.cars.store', 'show' => 'admin.cars.show', 'edit' => 'admin.cars.edit', 'update' => 'admin.cars.update', 'destroy' => 'admin.cars.destroy',]);
    Route::resource('/admin/users', AdminUserController::class)->names(['index' => 'admin.users.index', 'create' => 'admin.users.create', 'store' => 'admin.users.store', 'show' => 'admin.users.show', 'edit' => 'admin.users.edit', 'update' => 'admin.users.update', 'destroy' => 'admin.users.destroy',]);
    Route::post('users/{id}/set-admin', [AdminSetterController::class, 'setAdmin'])->name('admin.users.setadmin');
    Route::post('users/{id}/remove-admin', [AdminSetterController::class, 'removeAdmin'])->name('admin.users.removeadmin');

});

//     Route::get('/admin', [AdminController::class, 'index'])
//    name('admin.dashboard');