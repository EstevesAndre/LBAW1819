@extends('layouts.app')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">
        <div class="container mt-3 bg-white rounded shadow-lg">
            <div class="row align-items-center py-3">
                <div class="col-sm-12 col-lg-2 align-self-center">
                    <a href="/user/{{ $user->username }}">
                        <img width="90" class="img-fluid border rounded-circle" 
                            src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}" 
                        alt="User">
                    </a>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="text-left basic-info">
                        <h2><b>{{ $user->name }}</b>
                            <button type="button" class="border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#profile_helpModal">
                                <i class="fas fa-question-circle"></i>
                            </button>
                        </h2>
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
                        @if($clan === null) 
                            @if(Auth::user()->id != $user->id) <!-- Add verification to check if the authenticated user is already friend of this user->id -->
                                <div class="col-sm-12"><i class="fas fa-users"></i> No clan</div>
                            @else
                                <div class="col-sm-12"><i class="fas fa-users"></i><a href="/createClanPage"> Join a clan</a></div>
                            @endif
                        @else
                            <div class="col-sm-12"><i class="fas fa-users"></i> Clan: <a href='/clan'>{{ $clan->name }}</a></div>
                        @endif
                        <div class="col-sm-12 mt-1"><i class="fas fa-flag"></i> Race: {{ $user->race }}</div>
                        @if(Auth::user()->id != $user->id) <!-- Add verification to check if the authenticated user is already friend of this user->id -->
                            @if($status == 0)
                            <button type="button" class="col-sm-12 mt-5 btn btn-outline-success"> 
                                Add as Friend <i class="fas fa-user-plus"></i>
                            </button>
                            @elseif($status == 1)
                            <button type="button" class="col-sm-12 mt-5 btn btn-secondary" disabled> 
                                <i class="fas fa-user-slash"></i>
                            </button>
                            @elseif($status == 2)
                            <button type="button" class="col-sm-12 mt-5 btn btn-danger"> 
                                Cancel Request <i class="fas fa-times"></i>
                            </button>
                            @elseif($status == 3)
                            <div class="text-center w-100">
                                <button type="button" class="w-50 col-sm-12 mt-5 btn btn-success"> 
                                    Accept <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="w-50 col-sm-12 mt-2 btn btn-danger">   
                                    Decline <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @elseif($status == 4)
                            <button type="button" class="col-sm-12 mt-5 btn btn-outline-danger"> 
                                Remove Friendship <i class="fas fa-user-times"></i>
                            </button>
                            @endif
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
                    @if($friends->count() == 0) 
                        <p class="text-center"><b><small>{{ $user->name }}, you have 0 friends!</small></b></p>
                    @else
                        <div class="d-flex justify-content-center mb-3 mr-3">
                            <div class="searchbar">
                                <input class="search_input search_input_fixed" onkeyup="updateFriendList({{$user->id}})" type="text" name="" placeholder="Search...">
                                <div class="search_icon"><i class="fas fa-search"></i></div>
                            </div>
                        </div>
                        <ul class="list pl-0">
                            @each('partials.userList', $friends->take(5), 'user')
                            @if($friends->count() > 5) 
                                <p class="text-center mt-4 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => Auth::user()->friends()->get() ])
</div>
<div class="modal fade" id="profile_helpModal" tabindex="-1" role="dialog" aria-labelledby="profile_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profile_helpModalLabel">Profile Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the profile page.
            </div>
        </div>
    </div>
</div>
@endsection