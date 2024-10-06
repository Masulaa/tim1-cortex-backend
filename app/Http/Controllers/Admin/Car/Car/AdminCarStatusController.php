<?php

namespace App\Http\Controllers\Admin\Car\Car;

use App\Models\Car;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class AdminCarStatusController extends Controller
{
    public function carStatus()
    {
        $cars = Car::all();


        \Log::info('carStatus method called');

        return view('admin.cars.car_status', compact('cars'));
    }

    public function updateStatus(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->status = $request->input('status');
        $car->save();

        return response()->json(['message' => 'Car status updated successfully']);
    }
}
