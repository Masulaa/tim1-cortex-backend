<?php

use App\Http\Controllers\{
    Car\CarController,
    Car\RatingController,
    Car\ReservationController,
    User\AuthController,
    User\UserController,
};
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', [UserController::class, 'details']);
    Route::put('/user', [UserController::class, 'edit']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/cars', CarController::class);
    Route::put('/cars/{id}/status', [CarController::class, 'updateStatus']);

    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::delete('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::get('reservations/users/{user_id}', [ReservationController::class, 'userReservations']);
    Route::get('/reservations/{car_id}/reserved-dates', [ReservationController::class, 'reservedDates']);

    Route::get('/reservations/{id}/ratings', [RatingController::class, 'index']);
    Route::post('/reservations/{reservationId}/rate/{carId}', [RatingController::class, 'store']);
    Route::get('/reservations/{reservationId}/car/{carId}/check-rating', [RatingController::class, 'checkIfRated']);

});



