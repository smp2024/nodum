<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/css/style.css?v='.time()) }}">

</head>
<body style="
    margin: 0px;
    padding: 0px;
    background-color: #f3f3f3;">

    <div style="
        display: block;
        margin: 0px auto;
        max-width: 728px;
        width: 60%;">

        <img src="{{ url('media/imagenes/logo.png') }}" alt=""
            style="
                width: 27%;
                display: block;
                margin: 0px auto;">

        <div class="" style="
            backgorund-color: #fff;
            padding 24px;
        ">

            @yield('content')


        </div>

    </div>

</body>
</html>
