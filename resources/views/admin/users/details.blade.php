@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details: {{ $user->name }}</h1>
@endsection

@section('content')
    <h3>User Information</h3>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Created At:</strong> {{ $user->created_at }}</li>
        <li><strong>Status:</strong> {{ $user->is_blocked ? 'Blocked' : 'Active' }}</li>
    </ul>

    <h3>Rental History</h3>
    @if ($reservations->isEmpty())
        <p>This user has no rental history.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Car ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->car_id }}</td>
                        <td>{{ $reservation->start_date }}</td>
                        <td>{{ $reservation->end_date }}</td>
                        <td>{{ $reservation->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users List</a>
@endsection
