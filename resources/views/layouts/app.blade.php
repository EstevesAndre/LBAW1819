<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->  
        <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="{{ asset('../assets/logo.png') }}"/>
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
        <main>
        <header>
            <nav class="bg-secondary fixed-top navbar navbar-expand-lg fixed-nav">
                @if (Auth::check())
                    <a class="navbar-brand" href="../index.html">
                        <img src="../assets/logoWhite.png" width="40" height="40" alt="icon">
                        <a class="nav-link index-nav" href="../index.html">AlterEgo</a>
                    </a>
                @else
                    <a class="navbar-brand" href="../home.html">
                        <img src="../assets/logoWhite.png" width="40" height="40" alt="icon">
                        <a class="nav-link index-nav" href="{{ url('/cards') }}">AlterEgo</a>
                    </a>
                @endif
            </nav>
            <h1><a href="{{ url('/cards') }}">Thingy!</a></h1>
            @if (Auth::check())
            <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
            @endif
        </header>
        <section id="content">
            @yield('content')
        </section>
        </main>
    </body>
</html>

<nav class="bg-secondary fixed-top navbar navbar-expand-lg fixed-nav">
        <a class="navbar-brand" href="../index.html">
            <img src="../assets/logoWhite.png" width="40" height="40" alt="icon">
            <a class="nav-link index-nav" href="../index.html">AlterEgo</a>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars hamburger-icon"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class=" navbar-nav mr-auto">
                <li class="nav-item align-self-center">
                    <a class="nav-link index-nav active" href="../pages/about.html">Get Started!</a>
                </li>
                <li class="nav-item align-self-center">
                    <a class="nav-link index-nav" href="../pages/faqs.html">FAQs</a>
                </li>
            </ul>
            <div class="d-flex justify-content-center mr-2">
                <a href="../pages/login.html" class="btn btn-link bg-dark nav-link index-nav">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <nav class="bg-secondary fixed-top navbar navbar-expand-lg fixed-nav">
        <a class="navbar-brand" href="../pages/home.html">
            <img src="../assets/logoWhite.png" width="40" height="40" alt="icon">
            <a class="nav-link index-nav" href="../pages/home.html">AlterEgo</a>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars hamburger-icon"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item align-self-center">
                    <a class="nav-link index-nav active" href="../pages/profile.html">Profile</a>
                </li>
                <li class="nav-item align-self-center">
                    <a class="nav-link index-nav" href="../pages/clan.html">Clan</a>
                </li>
                <li class="nav-item align-self-center">
                    <a class="nav-link index-nav" href="../pages/leaderboard.html">Leaderboards</a>
                </li>
            </ul>
            <div class="d-flex justify-content-center mr-2">
                <div class="searchbar">
                    <input class="search_input" type="text" name="" placeholder="Search...">
                    <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-center mx-2 align-items-center">
                <div class="btn-group my-2">
                    <button type="button" class="btn btn-secondary rounded" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="fas fa-user-friends"></i></button>
                    <div class="dropdown-menu bg-secondary">
                        <a class="no-hover index-nav" href="../pages/friends.html"><button class="dropdown-item dropdown-navbar" type="button">Go to Friend Requests</button></a>
                    </div>
                </div>
                <div class="btn-group mr-1">
                    <button type="button" class="btn btn-secondary rounded" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="far fa-envelope"></i></button>
                    <div class="dropdown-menu bg-secondary">
                        <a class="no-hover index-nav" href="../pages/chat.html"><button class="dropdown-item dropdown-navbar" type="button">Go to Chat</button></a>
                    </div>
                </div>
                <div class="btn-group mr-3 my-2">
                    <button type="button" class="btn btn-secondary rounded" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><i class="far fa-bell"></i></button>
                    <div class="dropdown-menu bg-secondary">
                        <a class="no-hover index-nav" href="../pages/home.html"><button class="dropdown-item dropdown-navbar" type="button">Go to Notifications</button></a>
                    </div>
                </div>

                <a href="../pages/profile.html"><img width="40" class="img-fluid border rounded-circle mr-2"
                        src="../assets/logo.png" alt="User"></a>
                <a href="../pages/profile.html" class="m-0 no-hover index-nav">André Esteves</a>
                <div class="btn-group ml-2 my-2">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu dropdown-menu-right bg-secondary">
                        <a class="no-hover index-nav" href="../pages/createClan.html">
                            <button class="dropdown-item dropdown-navbar" type="button">Create Clan</button>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="no-hover index-nav" href="../pages/administrator.html">
                            <button class="dropdown-item dropdown-navbar" type="button">Administrator</button>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="no-hover index-nav" href="../index.html">
                            <button class="dropdown-item dropdown-navbar" type="button">Log out</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>