@extends('layouts.app')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">
        <div class="container mt-3 bg-white rounded shadow-lg">
            <div class="row align-items-center py-4" id="clan-header">
                <div class="col-sm-12 col-lg-2 align-self-center">
                    <a href="#"><img width="200" class="img-fluid border rounded-circle" src="../assets/logo.png"
                            alt="Clan"></a>
                </div>
                <div class="col-sm-12 col-lg-7 my-2 text-left clan-bio">
                    <div class=" text-left basic-info">
                        <h2><b>{{ $clan->name }}</b></h2>
                        <p>Clan bio, briefly describing the clan.</p>
                        <div class="my-2"><a class="no-hover standard-text" href="../pages/clanSettings.html"><i
                                    class="fas fa-cog"></i> Settings</a></div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 my-2 text-left clan-info">
                    <div class="my-2"><i class="fas fa-globe"></i> Rank: 52</div>
                    <div class="my-2"><i class="fas fa-user-cog"></i> Owner: André</div>
                    <div class="my-2"><i class="fas fa-users"></i> Members: 574</div>
                </div>
            </div>
        </div>
        <div class="clan-page-info">
            <ul class="mt-5 nav nav-tabs" id="clan-tabs" role="tablist">
                <li class="nav-item">
                    <a class="tab-title nav-link active" id="forum-tab" data-toggle="tab" href="#forum" role="tab"
                        aria-controls="forum" aria-selected="true">Forum</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab"
                        aria-controls="members" aria-selected="false">Members</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="leaderboard-tab" data-toggle="tab" href="#leaderboard"
                        role="tab" aria-controls="leaderboard" aria-selected="false">Leaderboard</a>
                </li>
            </ul>

            <div class="mt-4 tab-content" id="content">
                <div class="text-left tab-pane fade active show" id="forum" role="tabpanel"
                    aria-labelledby="forum-tab">
                    <div class="container post mt-4 mb-2 p-0">
                        <div class="cardbox text-left shadow-lg bg-white">
                            <div class="cardbox-heading">
                                <div class="dropdown float-right mt-3 mr-3">
                                    <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                        aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                    <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                        <a class="dropdown-item" href="#">Hide post</a>
                                        <a class="dropdown-item" href="#">Report</a>
                                    </div>
                                </div>
                                <div class="media m-0">
                                    <div class="d-flex m-3">
                                        <a href="../pages/profile.html"><img class="img-fluid rounded-circle"
                                                src="../assets/logo.png" alt="User"></a>
                                    </div>
                                    <div class="media-body ml-1 align-self-center">
                                        <a href="../pages/profile.html">
                                            <p class="text-dark m-0">André Esteves</p>
                                        </a>
                                        <small><span><i class="icon ion-md-pin mb-0"></i>Porto,
                                                Portugal</span></small>
                                        <small><span><i class="icon ion-md-time mt-0"></i>10 hours
                                                ago</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class="cardbox-item mx-3">
                                <p>Hello guys!!!<br />I'm here to announce that ... You will know, when it's time.
                                    Okokok</p>
                            </div>
                            <div class="cardbox-base">
                                <ul class="mx-3 mb-1">
                                    <li><a><i class="fa fa-thumbs-up"></i></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a><span>12 Likes</span></a></li>
                                </ul>
                                <ul class="mx-3 mt-2">
                                    <li><a href="../pages/post.html"><i class="fa fa-comments"></i></a></li>
                                    <li><a><em class="mr-5">12</em></a></li>
                                    <li><a href="../pages/post.html"><i class="fa fa-share-alt"></i></a></li>
                                    <li><a><em class="mr-3">03</em></a></li>
                                </ul>
                            </div>
                            <div class="cardbox-comments d-flex align-items-center">
                                <span class="comment-avatar float-left mr-2">
                                    <a href="../pages/profile.html"><img class="rounded-circle" src="../assets/logo.png"
                                            alt="Avatar"></a>
                                </span>
                                <div class="search-comment">
                                    <input placeholder="Write a comment..." type="text">
                                    <button><i class="fas fa-share-square"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container post mt-4 mb-2 p-0">
                        <div class="cardbox text-left shadow-lg bg-white">
                            <div class="cardbox-heading">
                                <div class="dropdown float-right mt-3 mr-3">
                                    <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                        aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                    <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                        <a class="dropdown-item" href="#">Hide post</a>
                                        <a class="dropdown-item" href="#">Report</a>
                                    </div>
                                </div>
                                <div class="media m-0">
                                    <div class="d-flex m-3">
                                        <a href="../pages/profile.html"><img class="img-fluid rounded-circle"
                                                src="../assets/logo.png" alt="User"></a>
                                    </div>
                                    <div class="media-body ml-1 align-self-center">
                                        <a href="../pages/profile.html">
                                            <p class="text-dark m-0">André Esteves</p>
                                        </a>
                                        <small><span><i class="icon ion-md-pin mb-0"></i>Porto,
                                                Portugal</span></small>
                                        <small><span><i class="icon ion-md-time mt-0"></i>10 hours
                                                ago</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class="cardbox-item mx-3">
                                <p>Hello guys!!!<br />I'm here to announce that ... You will know, when it's time.
                                    Okokok</p>
                            </div>
                            <div class="cardbox-base">
                                <ul class="mx-3 mb-1">
                                    <li><a><i class="fa fa-thumbs-up"></i></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a><span>12 Likes</span></a></li>
                                </ul>
                                <ul class="mx-3 mt-2">
                                    <li><a href="../pages/post.html"><i class="fa fa-comments"></i></a></li>
                                    <li><a><em class="mr-5">12</em></a></li>
                                    <li><a href="../pages/post.html"><i class="fa fa-share-alt"></i></a></li>
                                    <li><a><em class="mr-3">03</em></a></li>
                                </ul>
                            </div>
                            <div class="cardbox-comments d-flex align-items-center">
                                <span class="comment-avatar float-left mr-2">
                                    <a href="../pages/profile.html"><img class="rounded-circle" src="../assets/logo.png"
                                            alt="Avatar"></a>
                                </span>
                                <div class="search-comment">
                                    <input placeholder="Write a comment..." type="text">
                                    <button><i class="fas fa-share-square"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container post mt-4 mb-2 p-0">
                        <div class="cardbox text-left shadow-lg bg-white">
                            <div class="cardbox-heading">
                                <div class="dropdown float-right mt-3 mr-3">
                                    <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                                        aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                    <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                                        <a class="dropdown-item" href="#">Hide post</a>
                                        <a class="dropdown-item" href="#">Report</a>
                                    </div>
                                </div>
                                <div class="media m-0">
                                    <div class="d-flex m-3">
                                        <a href="../pages/profile.html"><img class="img-fluid rounded-circle"
                                                src="../assets/logo.png" alt="User"></a>
                                    </div>
                                    <div class="media-body ml-1 align-self-center">
                                        <a href="../pages/profile.html">
                                            <p class="text-dark m-0">André Esteves</p>
                                        </a>
                                        <small><span><i class="icon ion-md-pin mb-0"></i>Porto,
                                                Portugal</span></small>
                                        <small><span><i class="icon ion-md-time mt-0"></i>10 hours
                                                ago</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class="cardbox-item mx-3">
                                <p>Hello guys!!!<br />I'm here to announce that ... You will know, when it's time.
                                    Okokok</p>
                            </div>
                            <div class="cardbox-base">
                                <ul class="mx-3 mb-1">
                                    <li><a><i class="fa fa-thumbs-up"></i></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a href="../pages/profile.html"><img src="../assets/logo.png"
                                                class="img-fluid rounded-circle" alt="User"></a></li>
                                    <li><a><span>12 Likes</span></a></li>
                                </ul>
                                <ul class="mx-3 mt-2">
                                    <li><a href="../pages/post.html"><i class="fa fa-comments"></i></a></li>
                                    <li><a><em class="mr-5">12</em></a></li>
                                    <li><a href="../pages/post.html"><i class="fa fa-share-alt"></i></a></li>
                                    <li><a><em class="mr-3">03</em></a></li>
                                </ul>
                            </div>
                            <div class="cardbox-comments d-flex align-items-center">
                                <span class="comment-avatar float-left mr-2">
                                    <a href="../pages/profile.html"><img class="rounded-circle" src="../assets/logo.png"
                                            alt="Avatar"></a>
                                </span>
                                <div class="search-comment">
                                    <input placeholder="Write a comment..." type="text">
                                    <button><i class="fas fa-share-square"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <p class="text-center standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                </div>
                <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                            <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                        </div>
                    </div>
                    <ul class="pl-0">
                        <li class="list-group shadow-lg">
                            <button type="button" class="text-left list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-danger img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Tiago Alves</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">Friends since 2018</div>
                                </div>
                            </button>
                        </li>
                        <li class="list-group shadow-lg">
                            <button type="button" class="text-left list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-light img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Manuel Afonso</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">Friends since 2017</div>
                                </div>
                            </button>
                        </li>
                        <li class="list-group shadow-lg">
                            <button type="button" class="text-left list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-success img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Leandro Azevedo</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">Friends since 2015</div>
                                </div>
                            </button>
                        </li>
                        <li class="list-group shadow-lg">
                            <button type="button" class="text-left list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-secondary img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Daniel Silva</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">Friends since 2014</div>
                                </div>
                            </button>
                        </li>
                        <li class="list-group shadow-lg">
                            <button type="button" class="text-left list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-white img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Filipe Cardoso</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">Friends since 2013</div>
                                </div>
                            </button>
                        </li>
                        <li class="list-group shadow-lg">
                            <button type="button" class="text-left list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-info img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Mariana Costa</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">Friends since 2013</div>
                                </div>
                            </button>
                        </li>
                        <li class="list-group shadow-lg">
                            <button type="button" class="text-left list-group-item list-group-item-action">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-warning img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Joana Maria</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">Friends since 2013</div>
                                </div>
                            </button>
                        </li>
                        <p class="text-center mt-4 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                    </ul>
                </div>
                <div class="tab-pane fade" id="leaderboard" role="tabpanel"
                    aria-labelledby="leaderboard-tab">
                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                            <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                        </div>
                    </div>
                    <ol class="pl-0 shadow-lg">
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-danger img-fluid rounded-circle">
                                    </div>
                                    <div class="col-7 col-sm-6 text-left">Inês Ribeiro</div>
                                    <div class="col-3 col-sm-5 text-right">
                                        <img src="../assets/first.png" alt="logo">
                                    </div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-warning img-fluid rounded-circle">
                                    </div>
                                    <div class="col-7 col-sm-6 text-left">Rafaela Pereira</div>
                                    <div class="col-3 col-sm-5 text-right">
                                        <img src="../assets/second.png" alt="logo">
                                    </div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-success img-fluid rounded-circle">
                                    </div>
                                    <div class="col-7 col-sm-6 text-left">Bruno Marques</div>
                                    <div class="col-3 col-sm-5 text-right">
                                        <img src="../assets/third.png" alt="logo">
                                    </div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-info img-fluid rounded-circle">
                                    </div>
                                    <div class="col-10 col-sm-11 text-left">Claúdia Barreto</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-secondary img-fluid rounded-circle">
                                    </div>
                                    <div class="col-10 col-sm-11 text-left">Manuela Alves</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-success img-fluid rounded-circle">
                                    </div>
                                    <div class="col-10 col-sm-11 text-left">Charllote Marcus</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-danger img-fluid rounded-circle">
                                    </div>
                                    <div class="col-10 col-sm-11 text-left">Margarida Pinto</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-light img-fluid rounded-circle">
                                    </div>
                                    <div class="col-10 col-sm-11 text-left">João Miguel</div>
                                </div>
                            </li>
                        </button>
                        <p class="text-center py-2 bg-white standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12 col-md-4 col-lg-3 bg-light side-bar side">
        <div class="d-flex justify-content-center">
            <div class="searchbar searchbar-fixed">
                <input class="search_input search_fixed" type="text" name="" placeholder="Search...">
                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
            </div>
        </div>
        <div class="height-45 scroolable">
            <div class="list-group text-left" id="list-tab" role="tablist">
                <a class="friend-list list-group-item list-group-item-action active" id="list-1-list"
                    data-toggle="list" href="#list-1" role="tab" aria-controls="1">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-2-list" data-toggle="list"
                    href="#list-2" role="tab" aria-controls="2">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-3-list" data-toggle="list"
                    href="#list-3" role="tab" aria-controls="3">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-4-list" data-toggle="list"
                    href="#list-4" role="tab" aria-controls="3">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-5-list" data-toggle="list"
                    href="#list-5" role="tab" aria-controls="5">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-6-list" data-toggle="list"
                    href="#list-6" role="tab" aria-controls="6">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-7-list" data-toggle="list"
                    href="#list-7" role="tab" aria-controls="7">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-8-list" data-toggle="list"
                    href="#list-8" role="tab" aria-controls="8">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-9-list" data-toggle="list"
                    href="#list-9" role="tab" aria-controls="9">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-10-list" data-toggle="list"
                    href="#list-10" role="tab" aria-controls="10">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-11-list" data-toggle="list"
                    href="#list-11" role="tab" aria-controls="11">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-12-list" data-toggle="list"
                    href="#list-12" role="tab" aria-controls="12">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <p class="text-center list-group-item p-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
            </div>
        </div>
        <div class="border-left height-45">
            <div class="p-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-1" role="tabpanel" aria-labelledby="list-1-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-2" role="tabpanel" aria-labelledby="list-2-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-3" role="tabpanel" aria-labelledby="list-3-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-4" role="tabpanel" aria-labelledby="list-4-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">João Miguel</a>
                </div>
                <div class="tab-pane fade" id="list-5" role="tabpanel" aria-labelledby="list-5-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-6" role="tabpanel" aria-labelledby="list-6-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-7" role="tabpanel" aria-labelledby="list-7-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-8" role="tabpanel" aria-labelledby="list-8-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">João Miguel</a>
                </div>
                <div class="tab-pane fade" id="list-9" role="tabpanel" aria-labelledby="list-9-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-10" role="tabpanel" aria-labelledby="list-19-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-11" role="tabpanel" aria-labelledby="list-11-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-12" role="tabpanel" aria-labelledby="list-12-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">João Miguel</a>
                </div>
            </div>
            <div class="border-top border-left w-100 bottom-contained send-message p-0 d-flex align-items-center">
                <input type="text" class="m-2 border w-75 no-outline" id="message-box" placeholder="Write a message here..."
                    required>
                <button type="submit" class="btn btn-primary m-1 float-right" id="send-button">&#9993;</button>
            </div>
        </div>
    </div>
</div>

@endsection