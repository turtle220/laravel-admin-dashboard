<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/all.min.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css"> --}}
</head>
<body>
    <?php $user = Auth::user(); ?>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="page-wrapper chiller-theme chiller-theme">
                <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
                <nav id="sidebar" class="sidebar-wrapper">
                    <div class="sidebar-content">
                    <div class="sidebar-brand">
                        <a href="{{route('home')}}">Admin CPanel</a>
                        <div id="close-sidebar">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="sidebar-header">
                        <div class="user-pic">
                        <img class="img-responsive img-rounded" src="{{asset('images/admin.svg')}}"
                            alt="User picture">
                        </div>
                        <div class="user-info">
                        <span class="user-name">
                            <strong>{{$user->name}}</strong>
                        </span>
                        <span class="user-role">Administrator</span>
                        <span class="user-status">
                            <i class="fa fa-circle" color="green"></i>
                            <span>Online</span>
                        </span>
                        </div>
                    </div>

                    <!-- sidebar-header  -->
                    {{-- <div class="sidebar-search">
                        <div>
                        <div class="input-group">
                            <input type="text" class="form-control search-menu" placeholder="Search...">
                            <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                            </div>
                        </div>
                        </div>
                    </div> --}}

                    <!-- sidebar-menu  -->
                    <div class="sidebar-menu">
                        <ul>

                            <li class="header-menu">
                                <span>Quick Links</span>
                            </li>

                            <li>
                                <a href="{{route('users')}}">
                                    <i class="fa fa-users"></i>
                                    <span>Manage Users</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('donates')}}">
                                    <i class="fa fa-donate"></i>
                                    <span>Manage Donates</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('DonatesCounter')}}">
                                    <i class="fa fa-donate"></i>
                                    <span>Manage Donates Counter</span>
                                </a>
                            </li>


                            {{-- <li>
                                <a href="{{route('states')}}">
                                    <i class="fa fa-city"></i>
                                    <span>Manage States</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('categories')}}">
                                    <i class="fa fa-list-alt"></i>
                                    <span>Manage Categories</span>
                                </a>
                            </li> --}}

                        </ul>
                    </div>

                    <!-- sidebar-menu  -->
                    </div>
                </nav>

                <main class="page-content" style="background-color:#FFF;">
                    @yield('content')
                    <div class="clearfix"></div>
                </main>
                
            </div>
        </div>

    </div>
</body>
</html>
