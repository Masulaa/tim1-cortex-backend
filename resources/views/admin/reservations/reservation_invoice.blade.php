<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h3>Reservation Details</h3>
    <p><strong>User:</strong> {{ $reservation->user->name }}</p>
    <p><strong>Car:</strong> {{ $reservation->car->make }} {{ $reservation->car->model }}</p>
    <p><strong>Start Date:</strong> {{ $reservation->start_date }}</p>
    <p><strong>End Date:</strong> {{ $reservation->end_date }}</p>
    <p><strong>Total Price:</strong> ${{ $reservation->total_price }}</p>

    <div class="email-footer">
        <p>&copy; {{ date('Y') }} Quick Ride. All rights reserved.</p>
    </div>
</body>

</html>
