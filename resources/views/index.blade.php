@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="jumbotron">
                    <h1 class="display-4">Добро пожаловать!</h1>
                    <p class="lead">Это заглавная страница будущего лидера рынка по продажам цифровых ключей.</p>
                    @guest
                        <hr class="my-4">
                        <p>Для начала работы с сайтом пожалуйста, войдите или зарегистрируйтесь.</p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn-lg" href="{{route('login')}}" role="button">Вход</a>
                            <a class="btn btn-outline-primary btn-lg" href="{{route('register')}}" role="button">Регистрация</a>
                        </p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
@endsection
