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
            background-color: #4CAF50;
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

        a {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Your Account is Unblocked</h1>
        </div>

        <div class="email-body">
            <p>Dear {{ $user->name }},</p>
            <p>Your account has been successfully unblocked.</p>
            <p>You can now access all our services again.</p>

            <a
                style="background-color: #4F46E5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">
                href="{{ url('http://front.tim1.cortexakademija.com/home') }}">Visit
                Our Website</a>
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Quick Ride. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
