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

        $monthlyReservations = [
            'October' => 0,
            'November' => 0,
            'December' => 0,
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
        ];

        $reservations = Reservation::select(\DB::raw('MONTH(created_at) as month'), \DB::raw('count(*) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        foreach ($reservations as $reservation) {
            switch ($reservation->month) {
                case 10:
                    $monthlyReservations['October'] = $reservation->total;
                    break;
                case 11:
                    $monthlyReservations['November'] = $reservation->total;
                    break;
                case 12:
                    $monthlyReservations['December'] = $reservation->total;
                    break;
                case 1:
                    $monthlyReservations['January'] = $reservation->total;
                    break;
                case 2:
                    $monthlyReservations['February'] = $reservation->total;
                    break;
                case 3:
                    $monthlyReservations['March'] = $reservation->total;
                    break;
                case 4:
                    $monthlyReservations['April'] = $reservation->total;
                    break;
                case 5:
                    $monthlyReservations['May'] = $reservation->total;
                    break;
                case 6:
                    $monthlyReservations['June'] = $reservation->total;
                    break;
                case 7:
                    $monthlyReservations['July'] = $reservation->total;
                    break;
                case 8:
                    $monthlyReservations['August'] = $reservation->total;
                    break;
                case 9:
                    $monthlyReservations['September'] = $reservation->total;
                    break;
            }
        }

        $monthlyRatings = [
            'October' => 0,
            'November' => 0,
            'December' => 0,
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
        ];

        $ratings = Rating::select(\DB::raw('MONTH(created_at) as month'), \DB::raw('count(*) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        foreach ($ratings as $rating) {
            switch ($rating->month) {
                case 10:
                    $monthlyRatings['October'] = $rating->total;
                    break;
                case 11:
                    $monthlyRatings['November'] = $rating->total;
                    break;
                case 12:
                    $monthlyRatings['December'] = $rating->total;
                    break;
                case 1:
                    $monthlyRatings['January'] = $rating->total;
                    break;
                case 2:
                    $monthlyRatings['February'] = $rating->total;
                    break;
                case 3:
                    $monthlyRatings['March'] = $rating->total;
                    break;
                case 4:
                    $monthlyRatings['April'] = $rating->total;
                    break;
                case 5:
                    $monthlyRatings['May'] = $rating->total;
                    break;
                case 6:
                    $monthlyRatings['June'] = $rating->total;
                    break;
                case 7:
                    $monthlyRatings['July'] = $rating->total;
                    break;
                case 8:
                    $monthlyRatings['August'] = $rating->total;
                    break;
                case 9:
                    $monthlyRatings['September'] = $rating->total;
                    break;
            }
        }

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
        ));
    }

}
