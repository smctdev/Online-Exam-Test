<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <title>Link Invalid</title>
    <style>
        body,
        html {
            height: 100%;
        }

        h2,
        p {
            color: #212121;
        }

        .box {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            background-color: #ffffff;
        }

        .row {
            margin: auto !important;
            color: white;
        }

        .flexybox {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="row">
            <div class="col-md-6 flexybox">
                <div style="margin: auto">
                    <h2>Assessment end instantly!</h2>
                    <p>Oops! Look's like you viloated one of the rules.</p>
                    <p>If you think this is an error, Please send as email.</p>
                    <p>Email @: <a href="gmail.com">smctgroup2021@gmail.com</a></p>
                    <a href="/" class="btn btn-primary"> Visit our Site</a>
                </div>

            </div>
            <div class="col-md-6">
                <img src="{{ asset('/images/vectors/violation.png') }}" class="img-responsive" width="80%"
                    alt="expired link">
            </div>
        </div>
    </div>
</body>

</html>
