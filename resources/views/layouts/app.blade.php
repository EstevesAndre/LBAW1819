<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'AlterEgo') }}</title>

        <!-- Styles -->  
        <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Icon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('/assets/logo.png') }}"/>
        
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" defer></script>
        <script type="text/javascript" src={{ asset('js/bootstrap/bootstrap.min.js') }} defer></script>
        <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
    </head>
    <body>
        <main class="h-100">
        <header>
            @if (Auth::check())
                <nav class="bg-secondary fixed-top navbar navbar-expand-lg fixed-nav">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <img src="{{ asset('assets/logoWhite.png') }}" width="40" height="40" alt="icon">
                        <a class="nav-link index-nav" href="{{ url('/home') }}">AlterEgo</a>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars hamburger-icon"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item align-self-center">
                                <a class="nav-link index-nav" href="/user/{{ Auth::user()->id }}">Profile</a>
                            </li>
                            <li class="nav-item align-self-center">
                                <a class="nav-link index-nav" href="{{ url('/clan') }}">Clan</a>
                            </li>
                            <li class="nav-item align-self-center">
                                <a class="nav-link index-nav" href="{{ url('/leaderboard') }}">Leaderboards</a>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center mr-2">
                            <div class="searchbar">
                                <input class="search_input" type="text" name="" placeholder="Search...">
                                <a href="" class="search_icon"><i class="fas fa-search"></i></a> <!-- Change to form -->
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mx-2 align-items-center">
                            <div class="btn-group my-2">
                                <button type="button" class="btn btn-secondary rounded" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fas fa-user-friends"></i></button>
                                <div class="dropdown-menu bg-secondary">
                                    <a class="no-hover index-nav" href="{{ url('/friends') }}"><button class="dropdown-item dropdown-navbar" type="button">Go to Friend Requests</button></a>
                                </div>
                            </div>
                            <div class="btn-group mr-1">
                                <button type="button" class="btn btn-secondary rounded" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="far fa-envelope"></i></button>
                                <div class="dropdown-menu bg-secondary">
                                    <a class="no-hover index-nav" href="{{ url('/chat') }}"><button class="dropdown-item dropdown-navbar" type="button">Go to Chat</button></a>
                                </div>
                            </div>
                            <div class="btn-group mr-3 my-2">
                                <button type="button" class="btn btn-secondary rounded" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="far fa-bell"></i></button>
                                <div class="dropdown-menu bg-secondary">
                                    <a class="no-hover index-nav" href="{{ url('/home') }}"><button class="dropdown-item dropdown-navbar" type="button">Go to Notifications</button></a>
                                </div>
                            </div>

                            <a href="/user/{{ Auth::user()->id }}"><img width="40" class="img-fluid border rounded-circle mr-2" src="{{ asset('assets/logo.png') }}" alt="User"></a>
                            <a href="/user/{{ Auth::user()->id }}" class="m-0 no-hover index-nav">{{ Auth::user()->name }}</a>
                            <div class="btn-group ml-2 my-2">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu dropdown-menu-right bg-secondary">
                                    <a class="no-hover index-nav" href="{{ url('/createClan') }}">
                                        <button class="dropdown-item dropdown-navbar" type="button">Create Clan</button>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="no-hover index-nav" href="{{ url('/administrator') }}">
                                        <button class="dropdown-item dropdown-navbar" type="button">Administrator</button>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form method="GET" action="{{ route('logout') }}">
                                        <button type="submit" class="dropdown-item dropdown-navbar">Log out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            @else
                <nav class="bg-secondary fixed-top navbar navbar-expand-lg fixed-nav">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('assets/logoWhite.png') }}" width="40" height="40" alt="icon">
                        <a class="nav-link index-nav" href="{{ url('/') }}">AlterEgo</a>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars hamburger-icon"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class=" navbar-nav mr-auto">
                            <li class="nav-item align-self-center">
                                <a class="nav-link index-nav active" href="{{ url('/about') }}">Get Started!</a>
                            </li>
                            <li class="nav-item align-self-center">
                                <a class="nav-link index-nav" href="{{ url('/faqs') }}">FAQs</a>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center mr-2">
                            <a class="btn btn-link bg-dark nav-link index-nav" href="{{ url('/login') }}">Login</a>
                        </div>
                    </div>
                </nav>  
            @endif
        </header>
        <section id="content" class="mh-91">
            @yield('content')
        </section>
        <footer class="bg-secondary py-2 mt-5">
            <div class="footer-copyright text-center text-white">Copyright <i class="fas fa-copyright"></i> AlterEgo lbaw1843</div>
        </footer>
        </main>
    </body>
</html>