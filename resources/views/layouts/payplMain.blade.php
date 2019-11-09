<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
@yield('header')
<div class="container">
@yield('content')
</div>
@yield('footer')
<script  type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script  type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
<script  type="text/javascript" src="{{asset('js/popper.js')}}"></script>
</body>
</html>
