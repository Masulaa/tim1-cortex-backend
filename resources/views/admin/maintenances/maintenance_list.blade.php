@extends('adminlte::page')

@section('title', 'Maintenances')

@section('content_header')
    <h1>Maintenances</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Maintenances</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
                        <th>Scheduled Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenances as $maintenance)
                        <tr>
                            <td>{{ $maintenance->id }}</td>
                            <td>{{ $maintenance->car->make }} {{ $maintenance->car->model }}</td>
                            <td>{{ $maintenance->scheduled_date }}</td>
                            <!-- Koristi formatiranje ako je potrebno -->
                            <td>{{ $maintenance->status }}</td>
                            <td>
                                <a href="{{ route('admin.maintenances.edit', $maintenance->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.maintenances.destroy', $maintenance->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?');">Delete</button>
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
            <h3 class="card-title">Schedule Maintenance</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.maintenances.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="car_id">Car:</label>
                    <select name="car_id" id="car_id" class="form-control" required>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->make }} {{ $car->model }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="scheduled_date">Scheduled Date:</label>
                    <input type="date" name="scheduled_date" id="scheduled_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Schedule Maintenance</button>
            </form>
        </div>
    </div>
@endsection
