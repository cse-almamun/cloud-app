<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['subject'] }}</title>
    <style type="text/css">
        div {
            position: relative;
            margin: 5px 0;
        }

        a,
        a:hover {
            text-decoration: none;
            color: #ffffff;
        }

        p {
            padding: 5px 0;
        }

        .text-center {
            text-align: center;
        }

        .btn-blue {
            background-color: #3962d6;
            border: 0;
            border-radius: 0;
            color: #ffffff;
            padding: 5px 15px;
            font-size: 20px;
        }

    </style>
</head>

<body>

    <h5>Hi, {{ $data['fullName'] }}</h5>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <div class="text-center">
        <a href="{{ url($data['url']) }}" class="btn-blue" target="_blank" rel="noopener noreferrer">Reset
            Security Password</a>
    </div>
    <p><strong>Your One Time Verification code is: {{ $data['otp'] }}</strong></p>
    <p>This password reset link will expire in 60 minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
    <div>
        Thanks,<br>
        {{ config('app.name') }}
    </div>


</body>

</html>
