<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function index($id)
    {
        $ratings = Rating::where('car_id', $id)->get();

        return response()->json($ratings, 200);
    }

    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'string|nullable',
        ]);

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
