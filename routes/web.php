<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])
    ->middleware('auth', IsAdmin::class)->name('admin.dashboard');



//     Route::get('/admin', [AdminController::class, 'index'])
//    name('admin.dashboard');