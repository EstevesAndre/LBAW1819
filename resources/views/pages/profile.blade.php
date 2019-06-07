@extends('layouts.app')

@section('pageTitle', "$user->name")

@section('content')

<br />
<div class="profile mt-5 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">
        <div class="container mt-3 bg-white rounded shadow-lg">
            <div class="row align-items-center py-5">
                <div class="col-sm-12 col-lg-3 align-self-center">
                    <a href="/user/{{ $user->username }}">
                        <img width="90" class="img-fluid border rounded-circle" 
                            src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}" 
                        alt="User">
                    </a>
                </div>
                <div class="col-sm-12 col-lg-9 align-self-center">
                    <div class="basic-info">
                        <h2 class="text-left mb-3 mt-2"><b>{{ $user->name }}</b>
                            <button type="button" class="border-0 btn btn-default btn-circle profile-help" data-toggle="tooltip" data-placement="auto" data-html="true">
                                <i class="fas fa-question-circle"></i>
                            </button>
                        </h2>
                        <div class="container">
                            <div class="row text-left">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="mt-1"><i class="fas fa-birthday-cake"></i> Birthdate: <small>{{ $user->birthdate }}</small></div>
                                    <div class="mt-1"><i class="fas fa-flag"></i> Race: {{ $user->race }}</div>
                                    <div class="profile mt-1"><i class="fas fa-ankh"></i> Class: {{ $user->class }}</div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    @if($clan === null) 
                                        @if(Auth::user()->id != $user->id) <!-- Add verification to check if the authenticated user is already friend of this user->id -->
                                            <div class="mt-1"><i class="fas fa-users"></i> No clan</div>
                                        @else
                                            <div class="mt-1"><i class="fas fa-users"></i><a href="/createClanPage"> Join a clan</a></div>
                                        @endif
                                    @else
                                    <div class="mt-1"><i class="fas fa-users"></i> Clan: <a href='/clan/{{$clan->id}}'>{{ $clan->name }}</a></div>
                                    @endif
                                    <div class="mt-1"><i class="fas fa-level-up-alt"></i> Level: {{ floor($user->xp/100) }}</div>
                                    <div class="profile mt-1"><i class="fas fa-coins"></i> xP: {{ $user->xp }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-16 text-left mt-2">
                    <div class="row text-center mx-1">
                        @if(Auth::user()->id != $user->id) <!-- Add verification to check if the authenticated user is already friend of this user->id -->
                            @if($status == 0) <!-- received request refused ->  ADD AS FRIEND -->
                                <div class="text-center w-100">        
                                    <button type="button" class="friend-add friend-width col-sm-12 mt-3 btn btn-outline-success" data-id="{{$user->id}}"> 
                                        Add as Friend <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            @elseif($status == 1) <!-- //sent request refused BLOCKED REQUEST -->
                                <div class="text-center w-100">    
                                    <button type="button" class="col-sm-12 friend-width mt-3 btn btn-secondary" data-id="{{$user->id}}" disabled> 
                                        Friendship blocked <i class="fas fa-user-slash"></i>
                                    </button>
                                </div>
                            @elseif($status == 2) <!-- //sent request pending CANCEL REQUEST  -->
                                <div class="text-center w-100">
                                    <button type="button" class="friend-cancel friend-width col-sm-12 mt-3 btn btn-danger" data-id="{{$user->id}}"> 
                                        Cancel Request <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @elseif($status == 3) <!-- //received request pending  ANSWER REQUEST -->
                                <div class="friend-answers text-center w-100">
                                    <button type="button" class="friend-accept friend-width col-sm-12 mt-3 btn btn-success" data-id="{{$user->id}}"> 
                                        Accept <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="friend-decline friend-width col-sm-12 mt-2 btn btn-danger" data-id="{{$user->id}}">   
                                        Decline <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @elseif($status == 4) <!-- //are friends REMOVE FRIENDSHIP -->
                                <div class="text-center w-100">
                                    <button type="button" class="friend-width friend-remove col-sm-12 mt-3 btn btn-outline-danger" data-id="{{$user->id}}"> 
                                        Remove Friendship <i class="fas fa-user-times"></i>
                                    </button>
                                </div>
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
                <div class="text-center tab-pane fade active show" id="activity" role="tabpanel" aria-labelledby="actibity-tab">
                    @if(Auth::user()->id === $user->id)
                        <div class="cardbox-comments align-self-center">
                            <button type="button" class="btn btn-lg btn-dark mr-2" data-toggle="modal" data-target="#postModal">
                                Create a new post
                            </button>
                            <button type="button" class="border-0 btn btn-default rounded-circle profile-feed-help" data-toggle="tooltip" data-placement="auto" data-html="true">
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
                        @foreach($user->posts()->take(3) as $p)
                            @if($p->id != null)
                                @if($p->clan_id == null || (!Auth::user()->clan()->get()->isEmpty() && $p->clan_id == Auth::user()->clan()->get()[0]->id))
                                    @include('partials.post', ['post' => $p])
                                @endif
                            @else
                                @include('partials.share', ['share' => $p])
                            @endif
                        @endforeach
                        </div>
                        {{-- <div class="crs more-user-posts" data-id="3">See more <i class="fas fa-angle-down"></i></div> --}}
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
            <div class="modal-body pb-0">
                <div class="row align-items-center d-flex">
                    <form class="form-inline p-2 mb-0"  method="post" action="/api/post" enctype="multipart/form-data">  
                        {{csrf_field()}}
                        <div class="col-sm-12 col-md-4 mt-3">
                            <a href="/user/{{ Auth::user()->username }}">
                                <img width="95" class="img-fluid border rounded-circle mb-3" 
                                src="{{ asset('assets/avatars/'.Auth::user()->race.'_'.Auth::user()->class.'_'.Auth::user()->gender.'.bmp') }}"
                                alt="User"></a>
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                        <div class="col-sm-12 col-md-8 form-group align-self-center">
                            <div class="row align-items-center">
                                <textarea class="form-control post-content text-left mt-3 mx-3 w-100" name="content" rows="6" placeholder="Write your publication here..."></textarea>
                                <input type="hidden" name="clan_id" value="-1">
                                <div class="col-9 col-md-9"><input type="file" name="has_img" accept="image/png" class="form-control-file input-file mt-2" id="clanImage"></div>
                                <div class="col-3 col-md-3"><button type="submit" class="float-right btn btn-dark my-2 create" aria-label="Post">Post</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script type="text/javascript">
    var start = 3;
    var working = false;
    $(window).scroll(function() {
        if ($(this).scrollTop() + 1 >= $('body').height() - $(window).height()) {
            if (working == false) {
                console.log("LOADING");
                working = true;
                $.ajax({
                    type: "GET",
                    url: "/api/seeMoreProfile/"+start,
                    processData: false,
                    contentType: "application/json",
                    data: '',
                    success: function(ret) {
                        for (var i = 0; i < ret.length; i++) 
                        {
                            let cur_post = ret[i];
                            let post_img = document.querySelector('.cardbox-heading>.media>div>a>img');
                            let path =  post_img.getAttribute('src');
                            let path_header = path.substr(0, path.indexOf("/avatars/"));
                            if(cur_post[0] == 'post'){ //load posts
                                
                                $('#posts-list').append( getPostHTML(cur_post[2][0],cur_post[1], path_header));
                            }
                            else{ //load shares
                                $('#posts-list').append( getShareHTML(cur_post[1],cur_post[2][0], cur_post[3][0], cur_post[4][0], cur_post[5], path_header));
                            }
                        }
                        start += 3;
                        setTimeout(function() {
                                working = false;
                        }, 4000)
                    },
                    error: function(r) {
                        console.log("Something went wrong!");
                    }
                });
            }
        }
    });
</script>