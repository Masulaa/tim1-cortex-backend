<?php

namespace App\Http\Controllers\Car;

use App\Mail\ReservationPendingMail;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Car\Reservation\{
    StoreReservationRequest,
    UpdateReservationRequest
};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{

    public function reservedDates($car_id)
    {

        $reservations = Reservation::where('car_id', $car_id)
            ->whereIn('status', ['pending', 'reserved', 'in use'])
            ->get(['start_date', 'end_date']);


        $reservedDates = [];
        foreach ($reservations as $reservation) {
            $period = Carbon::parse($reservation->start_date)
                ->toPeriod($reservation->end_date);
            foreach ($period as $date) {
                $reservedDates[] = $date->format('Y-m-d H:i:s');
            }
        }

        return response()->json([
            'reserved_dates' => $reservedDates,
            'message' => 'Successfully listed reserved dates',
        ], 200);
    }

    public function userReservations($user_id)
    {
        $reservations = Reservation::where('user_id', $user_id)->get();

        $reservedReservationsCount = Reservation::where('status', 'reserved')
            ->where('start_date', '<=', now())
            ->count();

        if ($reservedReservationsCount > 0) {
            Reservation::where('status', 'reserved')
                ->where('start_date', '<=', now())
                ->update(['status' => 'in use']);
        }


        return response()->json([
            'reservations' => $reservations,
            'message' => 'Successfully listed reservations',
        ], 200);
    }

    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();


        $reservationStart = Carbon::parse($validated['start_date']);
        $now = Carbon::now();

        $minReservationTime = $now->copy()->addHours(24);

        if ($reservationStart->isBefore($minReservationTime)) {
            return response()->json(['message' => 'You must reserve at least 24 hours in advance'], 400);
        }

        $existingReservation = Reservation::where('user_id', $validated['user_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->first();

        if ($existingReservation) {
            return response()->json(['message' => 'You already have a reservation in this period'], 400);
        }

        $car = Car::find($validated['car_id']);
        $isCarAvailable = !$car->reservations()
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if (!$isCarAvailable) {
            return response()->json(['message' => 'The car is not available in the selected period'], 400);
        }

        $totalPrice = $this->calculateTotalPrice($car, $validated['start_date'], $validated['end_date']);

        $reservation = Reservation::create(array_merge($validated, [
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]));

        $user = User::find($request->user_id);

        Mail::to($user->email)->send(new ReservationPendingMail($reservation, $user));

        return response()->json(['message' => 'Reservation created successfully', 'reservation' => $reservation], 201);
    }

    public function update(UpdateReservationRequest $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $validated = $request->validated();

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
