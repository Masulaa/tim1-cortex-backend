@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Cars</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cars</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Transmission</th>
                        <th>Fuel Type</th>
                        <th>Doors</th>
                        <th>Price per Day</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td>{{ $car->make }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->transmission }}</td>
                            <td>{{ $car->fuel_type }}</td>
                            <td>{{ $car->doors }}</td>
                            <td>${{ $car->price_per_day }}</td>
                            <td>{{ $car->status }}</td>
                            <td>
                                <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this car?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New Car</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="make">Make</label>
                    <input type="text" class="form-control" id="make" name="make" placeholder="Car Make"
                        required>
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model" placeholder="Car Model"
                        required>
                </div>

                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="number" class="form-control" id="year" name="year" min="1900"
                        max="{{ date('Y') }}" placeholder="Car Year" required>
                </div>

                <div class="form-group">
                    <label for="transmission">Transmission</label>
                    <select class="form-control" id="transmission" name="transmission" required>
                        <option value="automatic">Automatic</option>
                        <option value="manual">Manual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fuel_type">Fuel Type</label>
                    <select class="form-control" id="fuel_type" name="fuel_type" required>
                        <option value="diesel">Diesel</option>
                        <option value="gasoline">Gasoline</option>
                        <option value="electricity">Electricity</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="doors">Doors</label>
                    <select class="form-control" id="doors" name="doors" required>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price_per_day">Price per Day</label>
                    <input type="number" class="form-control" id="price_per_day" name="price_per_day" min="0"
                        placeholder="Price per Day" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="available">Available</option>
                        <option value="under maintenance">Under Maintenance</option>
                        <option value="out of order">Out of Order</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control" name="description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>

                <button type="submit" class="btn btn-primary">Add Car</button>
            </form>
        </div>
    </div>
@endsection
