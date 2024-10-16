<?php

namespace App\Http\Controllers\Admin\Car\Reservation;

use App\Http\Requests\Admin\Car\Reservation\AdminReservationUpdateRequest;
use App\Mail\ReservationRejectedMail;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationAcceptedMail;


use App\Http\Controllers\Controller;

class AdminReservationController extends Controller
{
    public function index(Request $request)
    {

        $expiredReservations = Reservation::where('status', 'pending')
            ->where('start_date', '<', now())
            ->get();

        foreach ($expiredReservations as $reservation) {
            $user = $reservation->user;

            Mail::to($user->email)->send(new ReservationRejectedMail($user, $reservation));

            $reservation->delete();
        }


        Reservation::where('status', 'reserved')
            ->where('start_date', '<=', now())
            ->update(['status' => 'in use']);


        $reservations = Reservation::with(['car', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reservations.reservation_list', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = Reservation::with('car', 'user')->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $cars = Car::all();
        $users = User::all();
        return view('admin.reservations.reservation_edit', compact('reservation', 'cars', 'users'));
    }

    public function update(AdminReservationUpdateRequest $request, $id)
    {

        $reservation = Reservation::findOrFail($id);

        $startDate = new \DateTime($request->start_date);
        $startDate->setTime(11, 0, 0);

        $endDate = new \DateTime($request->end_date);
        $endDate->setTime(9, 0, 0);

        $reservation->start_date = $startDate;
        $reservation->end_date = $endDate;

        $reservation->save();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation updated successfully');
    }

    public function accept($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'reserved';
        $reservation->save();

        $car = $reservation->car;
        if ($car) {
            $car->status = 'reserved';
            $car->save();
        }
        $user = $reservation->user;
        Mail::to($user->email)->send(new ReservationAcceptedMail($user, $reservation));


        return redirect()->back()->with('success', 'Reservation is accepted');
    }


    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        $user = $reservation->user;

        Mail::to($user->email)->send(new ReservationRejectedMail($user, $reservation));
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation cancelled successfully');
    }

    public function generateInvoice($id)
    {
        $reservation = Reservation::findOrFail($id);

        $pdf = Pdf::loadView('admin.reservations.reservation_invoice', compact('reservation'));

        if (request()->has('download')) {
            return $pdf->download('invoice-' . $reservation->id . '.pdf');
        }

        return $pdf->stream('invoice-' . $reservation->id . '.pdf');
    }
}
