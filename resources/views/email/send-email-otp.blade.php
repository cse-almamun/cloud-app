<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Applicaiton OTP Confirmation</title>
    <style type="text/css">
        div {
            position: relative;
            margin: 5px 0;
        }

        a,
        a:hover {
            text-decoration: none;
        }

        p {
            padding: 5px 0;
        }

        .text-center {
            position: relative;
            text-align: center;
            font-family: 'Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif';
            letter-spacing: 1px;

        }

    </style>
</head>

<body>

    <h5>Hi</h5>
    <p>{{ $data['message'] }}
    </p>
    <div class="text-center">
        <h3>{{ $data['token'] }}</h3>
    </div>
    <div>
        Thanks,<br>
        {{ config('app.name') }}
    </div>

</body>

</html>
