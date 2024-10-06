@extends('adminlte::page')

@section('title', 'Rental History for ' . $car->make)

@section('content_header')
    <h1>Rental History for {{ $car->make }} {{ $car->model }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rental History</h3>
        </div>
        <div class="card-body">
            @if ($car->reservations->isEmpty())
                <p>This car has no rental history.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($car->reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->user->name }}</td>
                                <td>{{ $reservation->start_date }}</td>
                                <td>{{ $reservation->end_date }}</td>
                                <td>{{ $reservation->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Back to Cars List</a>
@endsection
