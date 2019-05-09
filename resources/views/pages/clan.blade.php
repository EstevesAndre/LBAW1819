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
                        <p>{{ $clan->description }}</p>
                        <div class="my-2"><a class="no-hover standard-text" href="{{ url('/clanSettings') }}"><i
                                    class="fas fa-cog"></i> Settings</a></div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 my-2 text-left clan-info">
                    <div class="my-2"><i class="fas fa-globe"></i> Rank: 0</div>
                    <div class="my-2"><i class="fas fa-user-cog"></i> Owner: {{ $owner->name }}</div>
                    <div class="my-2"><i class="fas fa-users"></i> Members: {{ count($members) }}</div>
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
                <div class="text-left tab-pane fade active show" id="forum" role="tabpanel" aria-labelledby="forum-tab">
                    @if(count($posts) == 0)
                        <p class="text-center"><b><small>No posts to be seen!</small></b></p>
                    @else
                        @each('partials.post', array_slice($posts,0,5), 'post')
                        <br />
                        @if(count($posts) > 5)
                            <p class="text-center standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                        @endif
                    @endif
                </div>
                <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                            <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                        </div>
                    </div>
                    <ul class="pl-0">
                        @each('partials.userList', array_slice($members,0,10), 'user')
                        @if(count($members) > 10) 
                            <p class="text-center mt-4 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                        @endif
                    </ul>
                </div>
                <div class="tab-pane fade" id="leaderboard" role="tabpanel" aria-labelledby="leaderboard-tab">
                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                            <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                        </div>
                    </div>
                    <ol class="pl-0 shadow-lg">
                        @for ($i = 0; $i < count($leaders); $i++)
                            <button data-id="/user/{{ $leaders[$i]->username }}" type="button" class="text-left list-group-item border-0 list-group-item-action">
                                <li class="ml-3">
                                    <div class="d-flex align-items-center row">
                                        <div class="col-2 col-sm-1 friend-img">
                                            <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border bg-danger img-fluid rounded-circle">
                                        </div>
                                        <div class="col-7 col-sm-6 text-left">{{ $leaders[$i]->name }}</div>
                                        <div class="col-3 col-sm-5 text-right">
                                            @if($i === 0)
                                                <img src="{{ asset('assets/first.png') }}" alt="logo">
                                            @elseif($i === 1)
                                                <img src="{{ asset('assets/second.png') }}" alt="logo">
                                            @elseif($i === 2)
                                                <img src="{{ asset('assets/third.png') }}" alt="logo">
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            </button>
                        @endfor
                        <p class="text-center py-2 bg-white standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => $friends])
</div>

@endsection