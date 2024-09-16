<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function userReservations($user_id)
    {
        $reservations = Reservation::where('user_id', $user_id)->get();

        return response()->json($reservations, 200);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'nullable|numeric|min:0'
        ]);

        $car = Car::find($validated['car_id']);
        $totalPrice = $this->calculateTotalPrice($car, $validated['start_date'], $validated['end_date']);

        $reservation = Reservation::create(array_merge($validated, [
            'total_price' => $totalPrice,
            'status' => $request->status ?? 'pending',
        ]));
        return response()->json(['message' => 'Reservation created successfully', 'reservation' => $reservation], 201);


    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $validated = $request->validate([
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
        ]);

        $reservation->update($validated);

        return response()->json(['message' => 'Reservation updated successfully'], 200);
    }

    // public function cancelReservation(Request $request, $id)
    // {
    //     $reservation = Reservation::find($id);

    //     if (!$reservation) {
    //         return response()->json(['message' => 'Reservation not found'], 404);
    //     }
    //     $now = Carbon::now();
    //     $startDate = new Carbon($reservation->start_date);

    //     if ($startDate->diffInHours($now) >= 48) {
    //         $reservation->status = 'cancelled';
    //         $reservation->save();
    //         return response()->json(['message' => 'Reservation cancelled successfully'], 200);
    //     } else {
    //         return response()->json(['message' => 'Reservation cannot be cancelled less than 48 hours before the start'], 400);
    //     }
    // }
    private function calculateTotalPrice(Car $car, $startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = $start->diff($end);
        $days = $interval->days;

        return $car->price_per_day * $days;
    }

}
