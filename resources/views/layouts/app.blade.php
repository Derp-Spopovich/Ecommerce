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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .show-img{
            height: 250px;
        }
        .product-show{
            max-height: 350px;
        }
        .input-search{
            width: 130px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: white;
            background-image: url('searchicon.png');
            background-position: 10px 10px; 
            background-repeat: no-repeat;
            padding: 12px 20px 12px 40px;
            -webkit-transition: width 0.4s ease-in-out;
            transition: width 0.4s ease-in-out;
        }
        .input-search:focus{
            width: 100%;
        }
        .banner-img{
            width: 900px;
            height: 350px;
        }
    </style>
    @livewireStyles
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    My Ecommerce
                </a>
                
                <a href="{{url('/explain/Website_explain.pdf')}}" target="_blank" class="navbar-brand">
                    AboutWebsite
                </a>

                @include('includes.search')
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
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @can('buyer-admin-users')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('payments.index', auth()->user())}}">Ordered</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('carts.show', auth()->user())}}">Cart ({{auth()->user()->carts()->count()}})</a>
                                </li>
                            @endCan
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    @can('admin-users')
                                        <a class="dropdown-item" href="{{route('admin.index_users')}}">View All Users</a>
                                        <a class="dropdown-item" href="{{route('admin.index_products')}}">View All Products</a>
                                    @endcan
                                    @can('seller-users')
                                        <a class="dropdown-item" href="{{route('payments.show', auth()->user())}}">View Orders</a>
                                        <a class="dropdown-item" href="{{route('products.create')}}">Create Product</a>
                                    @endCan
                                    <a class="dropdown-item" href="{{route('users.show', auth()->user())}}">View Profile</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="py-4">
            @include('includes.alert')
            @yield('content')
            <div class="mt-5">
                @include('includes.footer')
            </div>
        </main>
    </div>
    <script src="https://unpkg.com/turbolinks"></script> <!--for faster loading-->
    @livewireScripts
</body>
</html>
