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

}
