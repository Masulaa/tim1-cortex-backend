<!-- resources/views/emails/cancellation_invoice.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancellation Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 0.9em;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Cancellation Invoice</h1>
        </div>

        <p>Dear {{ $reservation->user->name }},</p>

        <p>Your reservation (ID: {{ $reservation->id }}) has been successfully cancelled.</p>

        <p>As per our cancellation policy, a cancellation fee of <span
                class="total">${{ number_format($cancellationFee, 2) }}</span> has been applied.</p>

        <p>Original Total Price: <span
                class="total">${{ number_format($reservation->total_price + $cancellationFee, 2) }}</span></p>
        <p>New Total Price after Cancellation Fee: <span
                class="total">${{ number_format($reservation->total_price, 2) }}</span></p>

        <p>Thank you for your understanding.</p>

        <div class="footer">
            <p>Best regards,</p>
            <p>Your Company Name</p>
        </div>
    </div>
</body>

</html>
