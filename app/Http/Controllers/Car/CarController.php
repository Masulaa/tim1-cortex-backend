<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Http\Requests\Car\Car\{
    CheckAvailabilityRequest,
    StoreCarRequest,
    UpdateCarRequest
};
use App\Models\Reservation;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Reservation::where('status', 'reserved')
            ->where('start_date', '<=', now())
            ->update(['status' => 'in use']);


        $cars = Car::all();


        return response()->json([
            'cars' => $cars,
            'message' => 'Successfully listed cars',
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $reservationIds = $car->reservations()->pluck('id');

        return response()->json([
            'car' => $car,
            'reservation_ids' => $reservationIds,
            'message' => 'Successfully listed the car',
        ], 200);
    }

    public function checkAvailability(CheckAvailabilityRequest $request)
    {
        $validated = $request->validated();

        $car = Car::find($request->car_id);

        $isAvailable = !$car->reservations()
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })->exists();

        if ($isAvailable) {
            return response()->json(['message' => 'Car is available'], 200);
        }

        return response()->json(['message' => 'Car is not available'], 400);
    }

    public function updateStatus(Request $request, $id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $car->status = $request->status;
        $car->save();

        return response()->json(['message' => 'Car status updated'], 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
