<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\{
    AdminCarStoreRequest,
    AdminCarUpdateRequest,
};
use App\Models\Car;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Storage;

class AdminCarsController extends Controller
{

    /**
     * Display a listing of all movies in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $cars = Car::all();

        return view('admin.cars.list', compact('cars'));
    }
    /**
     * Show the form for creating a new car.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $this->checkAdmin($request);
        return view('admin.cars-create'); // Kreiraj ovu Blade stranicu
    }

    /**
     * Store a newly created car in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminCarStoreRequest $request)
    {

        $car = new Car($request->all());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/cars-images');
            $car->image = str_replace('public/cars-images/', '', $path);
        }

        $car->save();

        return redirect()->route('admin.cars.index')->with('success', 'Car created successfully');
    }

    /**
     * Display the specified car details.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {

        $car = Car::findOrFail($id);

        return view('admin.cars-show', compact('car')); // Kreiraj ovu Blade stranicu
    }

    /**
     * Show the form for editing the specified car.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car')); // Kreiraj ovu Blade stranicu
    }


    public function update(AdminCarUpdateRequest $request, $id)
    {
        $car = Car::findOrFail($id);
        $validatedData = $request->validated();
        $car->fill($validatedData);

        if ($request->hasFile('image')) {
            if ($car->image && Storage::exists($car->image)) {
                Storage::delete($car->image);
            }

            $path = $request->file('image')->store('public/cars-images');
            $car->image = str_replace('public/cars-images/', '', $path);
        }

        $car->save();

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully');
    }

    /**
     * Remove the specified car from the database.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {

        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully');
    }
}
