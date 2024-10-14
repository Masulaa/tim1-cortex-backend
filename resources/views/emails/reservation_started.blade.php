<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Your Reservation Has Started</title>
</head>

<body>
    <h1>Hello {{ $user->name }},</h1>

    <p>We're excited to inform you that your reservation for the car <strong>{{ $reservation->car->make }}
            {{ $reservation->car->model }}</strong> has started.</p>

    <p>Your scheduled reservation period is from <strong>{{ $reservation->start_date }}</strong> to
        <strong>{{ $reservation->end_date }}</strong>.</p>

    <p>We hope you enjoy your ride! If you need any assistance, feel free to contact us.</p>

    <p>Best regards,<br>
        The Car Rental Team</p>
</body>

</html>
