<?php

namespace App\Http\Controllers\Admin\Car\Reservation;

use App\Models\Reservation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReturnedMail;

use App\Http\Controllers\Controller;

class AdminReservationStatusController extends Controller
{
    public function reservationStatus()
    {
        $reservations = Reservation::with('car', 'user')->get();

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
                    $user = $reservation->user;
                    Mail::to($user->email)->send(new ReservationReturnedMail($user, $reservation));
                    break;
            }
            $car->save();
        }

        return response()->json(['message' => 'Reservation status updated successfully']);
    }
}
