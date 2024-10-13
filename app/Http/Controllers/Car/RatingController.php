<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rating;
use App\Http\Requests\Car\Rating\{
    StoreRatingRequest,
};
use App\Models\Reservation;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function index($id)
    {
        $ratings = Rating::where('reservation_id', $id)->get();

        return response()->json([
            'ratings' => $ratings,
            'message' => 'Successfully listed ratings',
        ], 200);
    }

    public function store(StoreRatingRequest $request, $reservationId, $carId)
    {
        $request->validated();

        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $existingRating = Rating::where('user_id', $request->user()->id)
            ->where('reservation_id', $reservationId)
            ->first();

        if ($existingRating) {
            return response()->json(['message' => 'You have already rated this reservation'], 400);
        }

        $car = Car::find($carId);
        $reservation->ratings()->create([
            'user_id' => $request->user()->id,
            'reservation_id' => $reservation->id,
            'car_id' => $car->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Rating added'], 201);
    }

    public function checkIfRated($reservationId, $carId)
    {
        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $existingRating = Rating::where('reservation_id', $reservationId)
            ->where('car_id', $carId)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingRating) {
            return response()->json(['rated' => true, 'message' => 'Car has already been rated'], 200);
        }

        return response()->json(['rated' => false, 'message' => 'Car has not been rated'], 200);
    }

}
