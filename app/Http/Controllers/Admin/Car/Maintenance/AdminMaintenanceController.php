<?php

namespace App\Http\Controllers\Admin\Car\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Car\Maintenance\AdminMaintenanceRequest;
use App\Models\Maintenance;
use App\Models\Car;

use Illuminate\Http\Request;

class AdminMaintenanceController extends Controller
{
    public function index()
    {
        Car::whereHas('maintenances', function ($query) {
            $query->where('scheduled_date', today());
        })->update(['status' => 'under maintenance']);

        Car::whereHas('maintenances', function ($query) {
            $query->where('scheduled_date', '<', today());
        })->update(['status' => 'available']);



        $maintenances = Maintenance::with('car')->get();
        $cars = Car::all();
        return view('admin.maintenances.maintenance_list', compact('maintenances', 'cars')); // Proslijedi i $cars
    }


    public function create()
    {

        $cars = Car::all();
        return view('admin.maintenances.create', compact('cars'));
    }


    public function store(AdminMaintenanceRequest $request)
    {

        $validated = $request->validated();


        $maintenance = Maintenance::create($validated);

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance scheduled successfully.');
    }

    public function edit(Maintenance $maintenance)
    {

        $cars = Car::all();
        return view('admin.maintenances.maintenance_edit', compact('maintenance', 'cars'));
    }


    public function update(AdminMaintenanceRequest $request, Maintenance $maintenance) // Promenjen tip parametra
    {
        $validated = $request->validated();


        $maintenance->update($validated);


        if ($validated['status'] === 'under maintenance') {
            $maintenance->car->update(['status' => 'under maintenance']);
        }
        if ($validated['status'] === 'completed') {
            $maintenance->car->update(['status' => 'available']);
        }

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance updated successfully.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance deleted successfully.');
    }
}
