<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('pageTitle') - AlterEgo</title> 
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous" defer></script> --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js" defer></script>
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
                                <a class="nav-link index-nav" href="/user/{{ Auth::user()->username }}">Profile</a>
                            </li>
                            <li class="nav-item align-self-center">
                                @if(!Auth::user()->clan()->get()->isEmpty())
                                    <a class="nav-link index-nav" href="{{ url('/clan') }}">Clan</a>
                                @else 
                                    <a class="nav-link index-nav" href="{{ url('/createClanPage') }}">Create a Clan</a>
                                @endif
                            </li>
                            <li class="nav-item align-self-center">
                                <a class="nav-link index-nav" href="{{ url('/leaderboard') }}">Leaderboards</a>
                            </li>
                            <!-- Button trigger modal -->
                            <button type="button" class="border-0 btn btn-default rounded-circle" data-toggle="modal" data-target="#nav_helpModal">
                                <i class="fas fa-question-circle"></i>
                            </button>
                        </ul>
                        <div class="d-flex justify-content-center mr-2">
                            <form class="my-2 ml-4 mr-4" method="GET" action="/search">
                                <div class="searchbar">
                                    <input type ="text" class="search_input" name="search" placeholder="Search..." required>
                                    <button type="submit" class="search_icon btn btn-dark btn-circle">
                                            <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex justify-content-center mx-2 align-items-center">
                            <div class="btn-group my-2">
                                <button type="button" class="btn btn-secondary rounded-circle" onclick="window.location='{{ url('/friendRequests') }}'" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fas fa-user-friends"></i> (0)
                                </button>
                            </div>
                            <div class="btn-group mr-1">
                                <button type="button" class="btn btn-secondary rounded-circle" onclick="window.location='{{ url('/chat') }}'" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="far fa-envelope"></i>
                                </button>
                            </div>
                            <div class="btn-group mr-3 my-2" id="notifications">
                                <button type="button" class="btn btn-secondary rounded-circle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="far fa-bell"></i></button>
                                <div class="dropdown-menu text-center dropdown-menu-right text-light bg-dark">
                                    You have 0 notifications!
                                </div>
                            </div>

                            <a href="/user/{{ Auth::user()->username }}" class="nav-user"><img id="nav-user-img" data-id="{{Auth::user()->id }}" class="img-fluid border rounded-circle mr-3" 
                                src="{{ asset('assets/avatars/'.Auth::user()->race.'_'.Auth::user()->class.'_'.Auth::user()->gender.'.bmp') }}" alt="User"></a>
                            <a href="/user/{{ Auth::user()->username }}" class="m-0 no-hover index-nav">{{ Auth::user()->name }}</a>
                            <div class="btn-group ml-2 my-2">
                                <button type="button" class="btn btn-secondary dropdown-toggle rounded-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu dropdown-menu-right bg-secondary">
                                    @if(Auth::user()->clan()->get()->isEmpty())
                                        <a class="no-hover index-nav" href="{{ url('/createClanPage') }}">
                                            <button class="dropdown-item dropdown-navbar" type="button">Create Clan</button>
                                        </a>
                                    @endif
                                    @if(Auth::user()->clan()->get()->isEmpty() && Auth::user()->is_admin)
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    @if (Auth::user()->is_admin)
                                        <a class="no-hover index-nav" href="{{ url('/administrator') }}">
                                            <button class="dropdown-item dropdown-navbar" type="button">Administrator</button>
                                        </a>
                                    @endif
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
                                <a class="nav-link index-nav" href="{{ url('/about') }}">Get Started!</a>
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
         <!-- Modal -->
         <div class="modal fade" id="nav_helpModal" tabindex="-1" role="dialog" aria-labelledby="nav_helpModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nav_helpModalLabel">Navbar Help</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        This is the navbar.
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>