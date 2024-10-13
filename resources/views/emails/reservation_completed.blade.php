<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reservation is Completed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Hello, {{ $userName }}!</h1>
        <p>Thank you for using our service. We're glad to inform you that your reservation has been successfully
            completed.</p>

        <h2>Reservation Details:</h2>
        <ul>
            <li><strong>Reservation ID:</strong> {{ $reservationDetails->id }}</li>
            <li><strong>Car:</strong> {{ $reservationDetails->car->name }}</li>
            <li><strong>Start Date:</strong> {{ $reservationDetails->start_date }}</li>
            <li><strong>End Date:</strong> {{ $reservationDetails->end_date }}</li>
            <li><strong>Total Price:</strong> {{ $reservationDetails->total_price }} RSD</li>
        </ul>

        <p>If you have any questions or need further assistance, feel free to contact us.</p>

        <div class="footer">
            <p>Best regards,<br>Your Car Rental Team</p>
        </div>
    </div>

</body>

</html>
