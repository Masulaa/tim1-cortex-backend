<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rating;
use App\Http\Requests\Car\Rating\{
    StoreRatingRequest,
};
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function index($id)
    {
        $ratings = Rating::where('car_id', $id)->get();

        return response()->json(['ratings' => $ratings,
        'message' => 'Successfully listed ratings',], 200);
    }

    public function store(StoreRatingRequest $request, $id)
    {
        $validated = $request->validated();

        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $car->ratings()->create([
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Rating added'], 201);
    }

}
