<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New admin login credential!</title>
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

    </style>
</head>

<body>

    <h5>Hi, {{ $data['name'] }}</h5>
    <p>{{ $data['message'] }}
    </p>
    <p>
        <span><strong>Email: </strong>{{ $data['email'] }}</span><br>
        <span><strong>Temporary Password: </strong>{{ $data['tempPass'] }}</span>
    </p>
    <div>
        Thanks,<br>
        {{ config('app.name') }}
    </div>

</body>

</html>
