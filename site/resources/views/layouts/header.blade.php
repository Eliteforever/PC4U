<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id="csrf-token" content="{{ csrf_token() }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PC4U') }}</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/nouislider.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">


        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom-bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    </head>

    <body>
        <div id="app">
            <nav>
                <div class="nav-wrapper blue-grey lighten-1">
                    <a href="{{ route('home') }}" class="brand-logo">
                        <img alt="" src="{{ asset('imgs/logo.svg') }}"/>
                    </a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li>
                            <div class="searchbar input-field">
                                <i class="material-icons prefix">search</i>
                                <input class="searchInputHeader" placeholder="Zoek naar producten" type="text" id="generalSearchbar"></input>
                            </div>
                            <div class="searchbarResultContainer z-depth-2">
                                <div class="row">
                                    <div class="col s8">
                                        <div class="collection with-header searchbarList searchbarProductList">
                                            
                                        </div>
                                    </div>
                                    <div class="col s4">
                                        <div class="collection with-header searchbarList searchbarCategoryList">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @if(Auth::guest()) @elseif(Auth::user()->admin == "1")
                            <li>
                                <a class='dropdown-button' data-beloworigin="true" href="#" data-activates='admindrop'>Admin Pagina's</a>

                                <!-- Dropdown Structure -->
                                <ul id='admindrop' class='dropdown-content blue-grey lighten-1'>
                                    <li><a href="{{ route('categoriesAdmin') }}">Categorieën</a></li>
                                    <li><a href="{{ route('productsAdmin') }}">Producten</a></li>
                                    <li><a href="{{ route('adminSales') }}">Aanbiedingen</a></li>
                                    <li><a href="{{ route('getAllUsers') }}">Gebruikers</a></li>
                                    <li><a href="{{ route('commercial') }}">Promoties</a></li>
                                    <li><a href="{{ route('allOrdersAdmin') }}">Orders</a></li>
                                </ul>
                            </li>
                        @endif
                        <li><a href="{{ route('categories') }}">Shop</a></li>
                        <li><a href="{{ route('repair') }}">Reperatie</a></li>
                        <li>
                            <a href="{{ route('cart') }}" class="nav-item-icon">
                                <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24">
                                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                                    <path d="M0 0h24v24H0z" fill="none" />
                                </svg>
                                <span class="itemsInCart">(0)</span>
                            </a>
                        </li>
                        <li>
                            @if(Auth::user())
                                <a href="#!" class="dropdown-button" data-beloworigin="true" data-activates="userdrop">{{ \App\Traits\nameTrait::getName() }}</a>
                                <ul id='userdrop' class='dropdown-content blue-grey lighten-1'>
                                    <li><a href="{{ route('settings') }}">Instellingen</a></li>
                                    <li><a href="{{ route('orders') }}">Orders</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                    </li>
                                </ul>
                            @else
                                <a href="{{ route('login') }}">Log-in</a> @endif
                        </li>
                    </ul>
                    <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                </div>
            </nav>
              <ul id="slide-out" class="side-nav">
					<li><a class="subheader">Navigatie</a></li>
                    <li><a href="{{ route('categories') }}">Shop</a></li>
                    <li><a href="{{ route('repair') }}">Reperatie</a></li>
                    <li><div class="divider"></li>
						
						@if(Auth::user())
							<li><a class="subheader">{{ \App\Traits\nameTrait::getName() }}</a></li>
							<li><a href="{{ route('settings') }}">Instellingen</a></li>
							<li><a href="{{ route('orders') }}">Orders</a></li>
							<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
							<li><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form></li>
							
                        @else
                                <li><a href="{{ route('login') }}">Log-in</a></li>
						@endif
						
						@if(Auth::guest()) @elseif(Auth::user()->admin == "1")
							<li><div class="divider">
							<li><a class="subheader">Admin Pagina's</a></li>
							<li><a href="{{ route('categoriesAdmin') }}">Categorieën</a></li>
							<li><a href="{{ route('productsAdmin') }}">Producten</a></li>
							<li><a href="{{ route('adminSales') }}">Aanbiedingen</a></li>
							<li><a href="{{ route('getAllUsers') }}">Gebruikers</a></li>
							<li><a href="{{ route('commercial') }}">Promoties</a></li>
							<li><a href="{{ route('allOrdersAdmin') }}">Orders</a></li>
						@endif
              </ul>
              
            @if(session('message-success'))
                <div class="alert alert-success alert50">
                    <strong>Success!</strong> {{ session('message-success') }}
                </div>
            @endif 
	    @if(session('message-error'))
            <div class="alert alert-error alert50">
                <strong>Error!</strong> {{ session('message-error') }}
            </div>
        @endif @yield('content')
        </div>
        <footer class="page-footer blue-grey lighten-1">
            <div class="footer-copyright">
                <div class="footer-container">
                    © PC4U - {{ date("Y") }} | All rights reserved
                    <a class="grey-text text-lighten-4 right" href="{{ route('contact') }}">Contact</a>
                    <a class="grey-text footer-link text-lighten-4 right" href="{{ route('about-us') }}">Over ons</a>
                </div>
            </div>
        </footer>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/wNumb.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/nouislider.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/cookies.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/cart.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/admin/postcontrol.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/searchbar.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/toastLib.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/toast.js') }}"></script>
        @yield('external-scripts')
        <script>
            

            $(document).ready(function(){
                $(".button-collapse").sideNav();
            });
        </script>
    </body>
</html>
