<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Requests\Admin\Car\{
    AdminCarStoreRequest,
    AdminCarUpdateRequest,
};
use App\Models\Car;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Storage;

class AdminCarController extends Controller
{

    public function index(Request $request)
    {

        $cars = Car::all();

        return view('admin.cars.car_list', compact('cars'));
    }

    public function create(Request $request)
    {

        return view('admin.cars-create'); // Kreiraj ovu Blade stranicu
    }

    public function store(AdminCarStoreRequest $request)
    {

        $car = new Car($request->all());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cars-images', 'public');
            $filename = basename($path);
            $car->image = $filename;
        }
        $car->save();

        return redirect()->route('admin.cars.index')->with('success', 'Car created successfully');
    }

    public function show(Request $request, $id)
    {

        $car = Car::findOrFail($id);

        return view('admin.cars-show', compact('car'));
    }

    public function edit($id)
    {
        $carToEdit = Car::findOrFail($id);
        return view('admin.cars.car_edit', compact('carToEdit'));
    }


    public function update(AdminCarUpdateRequest $request, $id)
    {
        $car = Car::findOrFail($id);
        $validatedData = $request->validated();
        $car->fill($validatedData);

        if ($request->hasFile('image')) {
            if ($car->image && Storage::exists('public/cars-images/' . $car->image)) {
                Storage::delete('public/cars-images/' . $car->image);
            }

            $path = $request->file('image')->store('cars-images', 'public');
            $filename = basename($path);
            $car->image = $filename;
        } else {
            $car->image = $car->getOriginal('image');
        }

        $car->save();

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully');
    }

    public function destroy(Request $request, $id)
    {

        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully');
    }


}
