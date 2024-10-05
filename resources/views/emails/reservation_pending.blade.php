<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #4F46E5;
            padding: 10px 20px;
            border-radius: 10px 10px 0 0;
            color: #fff;
            text-align: center;
        }

        .email-body {
            padding: 20px;
        }

        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Hello, {{ $user->name }}</h1>
        </div>

        <div class="email-body">
            <p>Thank you for reserving a car with us!</p>
            <p>Your reservation request is pending. Below are your reservation details:</p>

            <ul>
                <li><strong>Car:</strong> {{ $reservation->car->make }} {{ $reservation->car->model }}</li>
                <li><strong>Start Date:</strong> {{ $reservation->start_date }}</li>
                <li><strong>End Date:</strong> {{ $reservation->end_date }}</li>
            </ul>

            <p>We will notify you once your reservation is confirmed.</p>

            <a href="{{ url('http://localhost:3000/home') }}"
                style="background-color: #4F46E5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">Visit
                Our Website</a>
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Quick Ride. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
