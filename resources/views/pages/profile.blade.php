@extends('layouts.app')

@section('pageTitle', "$user->name")

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
                        <p class="mt-0 mb-4">Birthdate: <small>{{ $user->birthdate }}</small></p>
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
                        <div class="profile col-sm-12 mt-1"><i class="fas fa-ankh"></i> Class: {{ $user->class }}</div>
                        @if(Auth::user()->id != $user->id) <!-- Add verification to check if the authenticated user is already friend of this user->id -->
                            @if($status == 0) <!-- received request refused ->  ADD AS FRIEND -->
                                <button type="button" class="friend-add col-sm-12 mt-5 btn btn-outline-success" data-id="{{$user->id}}"> 
                                    Add as Friend <i class="fas fa-user-plus"></i>
                                </button>
                            @elseif($status == 1) <!-- //sent request refused BLOCKED REQUEST -->
                                <button type="button" class="col-sm-12 mt-5 btn btn-secondary" data-id="{{$user->id}}" disabled> 
                                    Friendship blocked <i class="fas fa-user-slash"></i>
                                </button>
                            @elseif($status == 2) <!-- //sent request pending CANCEL REQUEST  -->
                                <button type="button" class="friend-cancel col-sm-12 mt-5 btn btn-danger" data-id="{{$user->id}}"> 
                                    Cancel Request <i class="fas fa-times"></i>
                                </button>
                            @elseif($status == 3) <!-- //received request pending  ANSWER REQUEST -->
                                <div class="friend-answers text-center w-100">
                                    <button type="button" class="friend-accept w-50 col-sm-12 mt-5 btn btn-success" data-id="{{$user->id}}"> 
                                        Accept <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="friend-decline w-50 col-sm-12 mt-2 btn btn-danger" data-id="{{$user->id}}">   
                                        Decline <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @elseif($status == 4) <!-- //are friends REMOVE FRIENDSHIP -->
                                <button type="button" class="friend-remove col-sm-12 mt-5 btn btn-outline-danger" data-id="{{$user->id}}"> 
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
                    @if(Auth::user()->id === $user->id)
                        <div class="cardbox-comments d-flex align-items-center">
                            <button type="button" class="btn btn-dark mr-2" data-toggle="modal" data-target="#postModal">
                                Create a new Post
                            </button>
                            <div class="search-comment" data-toggle="modal" data-target="#postModal">
                                <input placeholder="  New publication..." type="text" class="w-100">
                            </div>
                            <button type="button" class="border-0 btn btn-default rounded-circle" data-toggle="modal" data-target="#home_helpModal">
                                    <i class="fas fa-question-circle"></i>
                            </button>
                        </div>
                    @endif
                    @if($user->posts()->count() === 0 && Auth::user()->id === $user->id) 
                        <p class="text-center"><b><small>{{ $user->name }}, you have 0 publications!</small></b></p>
                    @elseif($user->posts()->count() === 0)
                        <p class="text-center"><b><small>{{ $user->name }} has 0 publications!</small></b></p>
                    @else
                        <div id="posts-list">
                        @foreach($user->posts()->take(5) as $p)
                            @if($p->id != null)
                                @include('partials.post', ['post' => $p])
                            @else
                                @include('partials.share', ['share' => $p])
                            @endif
                        @endforeach
                        </div>
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
<!-- Modal -->
@if(Auth::user()->id === $user->id)
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Create Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="clanID" value="-1">
                <div class="row align-items-center w-100 mx-2">
                    <div class="col-sm-12 col-md-4 mt-3">
                        <a href="/user/{{ Auth::user()->username }}">
                            <img width="95" class="img-fluid border rounded-circle mb-3" 
                            src="{{ asset('assets/avatars/'.Auth::user()->race.'_'.Auth::user()->class.'_'.Auth::user()->gender.'.bmp') }}"
                            alt="User"></a>
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                    <div class="col-sm-12 col-md-8 pr-5 form-group">
                        <textarea class="form-control post-content text-left mt-3 w-100" rows="6" placeholder="Write your publication here..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="float-right btn btn-secondary m-3">Add Image</button>
                <button type="submit" class="float-right btn btn-dark my-3 create" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">Post</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection