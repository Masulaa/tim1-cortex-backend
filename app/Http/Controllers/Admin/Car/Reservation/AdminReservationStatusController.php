<?php

namespace App\Http\Controllers\Admin\Car\Reservation;

use App\Models\Reservation;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class AdminReservationStatusController extends Controller
{
    public function reservationStatus()
    {
        $reservations = Reservation::with('car', 'user')->get();
        \Log::info('reservationStatus method called');

        return view('admin.reservations.reservation_status', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $newStatus = $request->input('status');
        $reservation->status = $newStatus;
        $reservation->save();

        $car = $reservation->car;
        if ($car) {
            switch ($newStatus) {
                case 'reserved':
                    $car->status = 'reserved';
                    break;
                case 'in use':
                    $car->status = 'reserved';
                    break;
                case 'returned':
                    $car->status = 'available';
                    break;
            }
            $car->save();
        }

        return response()->json(['message' => 'Reservation status updated successfully']);
    }
}
