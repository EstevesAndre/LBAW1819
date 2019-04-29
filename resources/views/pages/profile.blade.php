@extends('layouts.app')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">
        <div class="container mt-3 bg-white rounded shadow-lg">
            <div class="row align-items-center py-3">
                <div class="col-sm-12 col-lg-2 align-self-center">
                    <a href="/user/{{ $user->id }}">
                        <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User">
                    </a>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="text-left basic-info">
                        <h2><b>{{ $user->name }}</b></h2>
                        <p class="my-0">Birthdate: <small>{{ $user->birthdate }}</small></p>
                        <p class="mt-0">Class: <small>{{ $user->class }}</small></p>
                    </div>
                    <div class="text-left">
                        LVL {{ floor($user->xp/100) }}
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: 75%">
                            </div>
                            {{ $user->xp }} XP
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 text-left mt-2 py-3">
                    <div class="row text-center mx-1">
                        @if($clan->first() == null) 
                            @if(Auth::user()->id != $user->id) <!-- Add verification to check if the authenticated user is already friend of this user->id -->
                                <div class="col-sm-12"><i class="fas fa-users"></i> No clan</div>
                            @else
                                <div class="col-sm-12"><i class="fas fa-users"></i><a href="#"> Join a clan</a></div>
                            @endif
                        @else
                            <div class="col-sm-12"><i class="fas fa-users"></i> Clan: <a href='/clan/{{ $clan[0]->id }}'>{{ $clan[0]->name }}</a></div>
                        @endif
                        <div class="col-sm-12 mt-1"><i class="fas fa-flag"></i> Race: {{ $user->race }}</div>
                        @if(Auth::user()->id != $user->id) <!-- Add verification to check if the authenticated user is already friend of this user->id -->
                            <button type="button" class="col-sm-12 mt-5 btn btn-outline-danger"> <!-- Add action to send friend request -->
                                Add as Friend <i class="fas fa-user-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-page-info mb-4">
            <ul class="mt-5 nav nav-tabs" id="profile-tabs" role="tablist">
                <li class="nav-item">
                    <a class="tab-title nav-link active" id="activity-tab" data-toggle="tab" href="#activity"
                        role="tab" aria-controls="activity" aria-selected="true">Activity</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="friends-tab" data-toggle="tab" href="#friends" role="tab"
                        aria-controls="friends" aria-selected="false">Friends List</a>
                </li>
            </ul>

            <div class="mt-4 tab-content" id="content">
                <div class="text-left tab-pane fade active show" id="activity" role="tabpanel" aria-labelledby="actibity-tab">
                    @if($user->posts()->count() === 0) 
                        <p class="text-center"><b><small>{{ $user->name }}, you have 0 publications!</small></b></p>
                    @else
                        @each('partials.post', $user->posts()->orderBy('date', 'desc')->skip(0)->take(5)->get(), 'post')
                        @if($user->posts()->count() > 5)
                            <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                        @endif
                    @endif
                </div>
                <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                    @if(count($friends) == 0) 
                        <p class="text-center"><b><small>{{ $user->name }}, you have 0 friends!</small></b></p>
                    @else
                        <div class="d-flex justify-content-center mb-3 mr-3">
                            <div class="searchbar">
                                <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                        <ul class="pl-0">
                            @each('partials.userList', array_slice($friends,0,5), 'user')
                            @if(count($friends) > 5) 
                                <p class="text-center mt-4 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
                        </ul>
                    @endif
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