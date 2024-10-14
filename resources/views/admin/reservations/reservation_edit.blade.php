@extends('adminlte::page')

@section('title', 'Edit Reservation')

@section('content_header')
    <h1>Edit Reservation</h1>
@endsection

@section('content')
    <form id="reservationForm" action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $reservation->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="car_id">Car</label>
            <select name="car_id" id="car_id" class="form-control">
                @foreach ($cars as $car)
                    <option value="{{ $car->id }}" {{ $reservation->car_id == $car->id ? 'selected' : '' }}>
                        {{ $car->make }} {{ $car->model }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date"
                value="{{ $reservation->start_date->format('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date"
                value="{{ $reservation->end_date->format('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="reserved" {{ $reservation->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                <option value="in use" {{ $reservation->status == 'in use' ? 'selected' : '' }}>In Use</option>
                <option value="returned" {{ $reservation->status == 'returned' ? 'selected' : '' }}>Returned</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Reservation</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reservationForm');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            form.addEventListener('submit', function(event) {
                // Pre nego što se pošalje forma, dodajemo fiksno vreme u 11h za start date i 9h za end date
                let startDate = new Date(startDateInput.value);
                startDate.setHours(11, 0, 0); // Postavi 11:00
                startDateInput.value = startDate.toISOString().slice(0, 10); // Datum bez vremena

                let endDate = new Date(endDateInput.value);
                endDate.setHours(9, 0, 0); // Postavi 09:00
                endDateInput.value = endDate.toISOString().slice(0, 10); // Datum bez vremena
            });
        });
    </script>
@endsection
