@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details: {{ $user->name }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Information</h3>
        </div>
        <div class="card-body">
            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Created At:</strong> {{ $user->created_at }}</li>
                <li><strong>Status:</strong> {{ $user->is_blocked ? 'Blocked' : 'Active' }}</li>
            </ul>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Rental History</h3>
        </div>
        <div class="card-body">
            @if ($reservations->isEmpty())
                <p>This user has no rental history.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->car->make }} {{ $reservation->car->model }}</td>
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

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users List</a>
@endsection
