@extends('adminlte::page')

@section('title', 'Edit Maintenance')

@section('content_header')
    <h1>Edit Maintenance</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.maintenances.update', $maintenance->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="car_id">Car:</label>
                    <select name="car_id" id="car_id" class="form-control" required>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}" {{ $car->id == $maintenance->car_id ? 'selected' : '' }}>
                                {{ $car->make }} {{ $car->model }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="scheduled_date">Scheduled Date:</label>
                    <input type="date" name="scheduled_date" id="scheduled_date" class="form-control"
                        value="{{ $maintenance->scheduled_date }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" class="form-control">{{ $maintenance->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ $maintenance->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="under maintenance"
                            {{ $maintenance->status == 'under maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Maintenance</button>
            </form>
        </div>
    </div>
@endsection
