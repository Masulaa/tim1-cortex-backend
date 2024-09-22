<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Admin\AdminController,
    Admin\AdminCarsController
};

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->middleware('auth', IsAdmin::class)->name('admin.dashboard');
    Route::resource('/admin/cars', AdminCarsController::class)->names(['index' => 'admin.cars.index', 'create' => 'admin.cars.create', 'store' => 'admin.cars.store', 'show' => 'admin.cars.show', 'edit' => 'admin.cars.edit', 'update' => 'admin.cars.update', 'destroy' => 'admin.cars.destroy',]);
    ;

});

//     Route::get('/admin', [AdminController::class, 'index'])
//    name('admin.dashboard');