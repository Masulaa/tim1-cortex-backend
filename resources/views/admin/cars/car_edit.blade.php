@extends('adminlte::page')

@section('title', 'Edit Car')

@section('content_header')
    <h1>Edit Car</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.cars.update', $carToEdit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="make">Make</label>
                    <input type="text" class="form-control" id="make" name="make" value="{{ $carToEdit->make }}"
                        placeholder="Car Make" required>
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model" value="{{ $carToEdit->model }}"
                        placeholder="Car Model" required>
                </div>

                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="number" class="form-control" id="year" name="year" value="{{ $carToEdit->year }}"
                        min="1900" max="{{ date('Y') }}" placeholder="Car Year" required>
                </div>

                <div class="form-group">
                    <label for="transmission">Transmission</label>
                    <select class="form-control" id="transmission" name="transmission" required>
                        <option value="automatic" {{ $carToEdit->transmission == 'automatic' ? 'selected' : '' }}>Automatic
                        </option>
                        <option value="manual" {{ $carToEdit->transmission == 'manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fuel_type">Fuel Type</label>
                    <select class="form-control" id="fuel_type" name="fuel_type" required>
                        <option value="diesel" {{ $carToEdit->fuel_type == 'diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="gasoline" {{ $carToEdit->fuel_type == 'gasoline' ? 'selected' : '' }}>Gasoline
                        </option>
                        <option value="electricity" {{ $carToEdit->fuel_type == 'electricity' ? 'selected' : '' }}>
                            Electricity</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="doors">Doors</label>
                    <select class="form-control" id="doors" name="doors" required>
                        <option value="2" {{ $carToEdit->doors == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $carToEdit->doors == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $carToEdit->doors == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ $carToEdit->doors == 5 ? 'selected' : '' }}>5</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price_per_day">Price per Day</label>
                    <input type="number" class="form-control" id="price_per_day" name="price_per_day"
                        value="{{ $carToEdit->price_per_day }}" min="0" placeholder="Price per Day" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="available" {{ $carToEdit->status == 'available' ? 'selected' : '' }}>Available
                        </option>
                        <option value="under maintenance"
                            {{ $carToEdit->status == 'under maintenance' ? 'selected' : '' }}>Under
                            Maintenance</option>
                        <option value="out of order" {{ $carToEdit->status == 'out of order' ? 'selected' : '' }}>Out of
                            Order</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control" name="description" rows="3">{{ $carToEdit->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Upload Image</label>
                    @if ($carToEdit->image)
                        <p>Current Image: <img src="{{ asset('storage/cars-images/' . $carToEdit->image) }}"
                                alt="Car Image" width="100"></p>
                    @endif
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>

                <button type="submit" class="btn btn-primary">Update Car</button>
            </form>


        </div>
    </div>
@stop
