<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet'>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/804834f0e7.js" crossorigin="anonymous"></script>
    <script src="{{ asset('jquery.js') }}"></script>

    <style>
        body {
            font-family: "Arimo", sans-serif;
        }
    </style>

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="/">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                       placeholder="Pretraži po tekstu ili ID-u"
                                       aria-label="Text input with segmented dropdown button">
                                <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa-solid fa-list"></i> Sortiraj
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('confessions.sortDsc') }}">
                                <i class="fas fa-arrow-down"></i> Najnovije
                            </a>
                            <a class="dropdown-item" href="{{ route('confessions.sortRnd') }}">
                                <i class="fas fa-random"></i> Slučajno
                            </a>
                            <a class="dropdown-item" href="{{ route('confessions.sortAsc') }}">
                                <i class="fas fa-arrow-up"></i> Najstarije
                            </a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('confessions.create') }}"><i class="fa-solid fa-feather"></i>
                            Ostavi ispovijed</a>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i
                                        class="fas fa-sign-in-alt"></i> {{ __('Prijavi se') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}"><i
                                        class="fas fa-user-plus"></i> {{ __('Registriraj se') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('savedConfession') }}">
                                    <i class="fa-sharp fa-solid fa-bookmark text-secondary"></i> Spremljene ispovijesti
                                    <span class="badge bg-secondary"
                                          id="saveConfessionCount">{{count(Auth::user()->saveConfessions)}}</span>
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket text-secondary"></i> {{ __('Odjavite se') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @include('messages.flash-message')
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
