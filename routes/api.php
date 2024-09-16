<?php

use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', [UserController::class, 'details']);
    Route::put('/user', [UserController::class, 'edit']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/cars', CarController::class);
    Route::post('/cars/check-availability', [CarController::class, 'checkAvailability']);
    Route::put('/cars/{id}/status', [CarController::class, 'updateStatus']);

    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::get('reservations/users/{user_id}', [ReservationController::class, 'userReservations']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);

    Route::get('/cars/{id}/ratings', [RatingController::class, 'index']);
    Route::post('/cars/{id}/rate', [RatingController::class, 'store']);

});



