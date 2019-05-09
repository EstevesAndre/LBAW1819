@extends('layouts.app')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen-3-4 m-0 standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">

        <div class="clan-page-info">
            <ul class="d-flex justify-content-center mt-3 nav nav-tabs" id="clan-tabs" role="tablist">
                <li class="nav-item">
                    <a class="tab-title nav-link active" id="global-tab" data-toggle="tab" href="#global" role="tab"
                        aria-controls="forum" aria-selected="true">Global</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="clan-tab" data-toggle="tab" href="#clan" role="tab"
                        aria-controls="members" aria-selected="false">Clan</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="friends-tab" data-toggle="tab" href="#friends" role="tab"
                        aria-controls="leaderboard" aria-selected="false">Friends</a>
                </li>
            </ul>

            <div class="mt-4 tab-content" id="leaderboard-content">
                <div class="text-left tab-pane fade border-0 active show" id="global" role="tabpanel" aria-labelledby="global-tab">
                    @if($global->count() === 0)
                        <p class="text-center py-2 bg-white">There are no users</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $global])
                    @endif
                </div>

                <div class="tab-pane fade" id="clan" role="tabpanel" aria-labelledby="clan-tab">
                    @if($clanMembers === null)
                        <p class="text-center py-2 bg-white">Join a clan or create one</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $clanMembers])
                    @endif
                </div>

                <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                    @if(count($friends) === 0)
                        <p class="text-center py-2 bg-white">{{ Auth::user()->name }}, you have no friends, add a friend</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $friends])
                    @endif
                </div>
            </div>
        </div>
    </div>

{{-- 
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
     --}}
</div>

@endsection