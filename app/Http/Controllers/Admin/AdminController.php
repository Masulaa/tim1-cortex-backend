<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use App\Models\Reservation;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalCars = Car::count();
        $totalReservations = Reservation::count();
        $totalRatings = Rating::count();
        $totalUsers = User::count();

        $reservationsThisMonth = Reservation::whereMonth('created_at', date('m'))->count();

        $topRatedCars = Car::with('ratings')
            ->select('cars.*')
            ->selectRaw('AVG(ratings.rating) as average_rating')
            ->join('ratings', 'ratings.car_id', '=', 'cars.id')
            ->groupBy(
                'cars.id',
                'cars.make',
                'cars.model',
                'cars.year',
                'cars.transmission',
                'cars.fuel_type',
                'cars.doors',
                'cars.price_per_day',
                'cars.status',
                'cars.description',
                'cars.image',
                'cars.created_at',
                'cars.updated_at'
            )
            ->orderBy('average_rating', 'desc')
            ->take(5)
            ->get();

        $monthlyReservations = Reservation::select(\DB::raw('MONTH(created_at) as month'), \DB::raw('count(*) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyRatings = Rating::select(\DB::raw('MONTH(created_at) as month'), \DB::raw('count(*) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $carStatuses = Car::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $reservationStatuses = Reservation::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalCars',
            'totalReservations',
            'totalRatings',
            'totalUsers',
            'reservationsThisMonth',
            'topRatedCars',
            'monthlyReservations',
            'monthlyRatings',
            'carStatuses',
            'reservationStatuses'
        )); // Ova linija bi trebala biti ispravna
    }

}
