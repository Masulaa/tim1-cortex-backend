<?php

namespace App\Http\Controllers\Admin\Car\Reservation;


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

    public function cancel(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $currentTime = now();
        $startDate = $reservation->start_date;

        // Primeniti pravilo o otkazu
        if ($currentTime->diffInHours($startDate) < 48) {
            $cancellationFee = $reservation->total_price * 0.50;
            // Ovde možeš dodati logiku za obaveštenje korisnika o naknadi
            return response()->json([
                'status' => 'error',
                'message' => 'Cancellation fee of 50% applies as the cancellation is within 48 hours of the start date.',
                'cancellation_fee' => $cancellationFee
            ], 403); // 403 Forbidden ili 422 Unprocessable Entity, zavisno od tvog pravila
        }

        $reservation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation cancelled successfully'
        ], 200); // 200 OK
    }


    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $currentTime = now();
        $startDate = $reservation->start_date;

        // Proveri da li je izmena rezervacije manje od 48 sati pre početka
        if ($currentTime->diffInHours($startDate) < 48) {
            // Primeniti politiku 50% naknade
            $cancellationFee = $reservation->total_price * 0.50;
            // Ovde možeš dodati logiku za obračun ili obaveštenje korisnika o naknadi
        }

        $reservation->update($request->all());

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
