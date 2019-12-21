
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>PayPlay Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md shadow-sm">
            <a class="navbar-brand" href="{{url('/')}}">
                <img class="logo" src="{{asset('/images/logo.png')}}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav mr-4">
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Вход') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выйти') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </ul>
            </div>
        </nav>
    </header>
    <main class="py-4">
        @yield('content')
    </main>
<script  type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script  type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
<script  type="text/javascript" src="{{asset('js/popper.js')}}"></script>
</body>
</html>
