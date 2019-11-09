<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
@yield('header')
<div class="container">
@yield('content')
</div>
@yield('footer')
</body>
</html>
