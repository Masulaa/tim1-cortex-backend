<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .details,
        .car-details,
        .total {
            margin-bottom: 20px;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Invoice for Reservation #{{ $reservation->id }}</h1>

        <div class="details">
            <p><strong>Customer Name:</strong> {{ $reservation->user->name }}</p>
            <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
        </div>

        <div class="car-details">
            <p><strong>Car:</strong> {{ $reservation->car->name }}</p>
            <p><strong>Start Date:</strong> {{ $reservation->start_date }}</p>
            <p><strong>End Date:</strong> {{ $reservation->end_date }}</p>
        </div>

        <div class="total">
            <p><strong>Total Price:</strong> {{ $reservation->total_price }} $</p>
        </div>
    </div>

</body>

</html>
