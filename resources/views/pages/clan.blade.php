@extends('layouts.app')

@section('pageTitle', $clan->name)

@section('content')

<br />
<div class="mt-5 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">
        <div class="container mt-3 bg-white rounded shadow-lg">
            <div class="row align-items-center py-4" id="clan-header">
                <div class="col-sm-12 col-lg-2 align-self-center">
                    @if(file_exists('assets/clanImgs/'.$clan->id.'.png'))
                    <a href="#"><img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan->id.'.png')}}"
                            alt="Clan"></a>
                    @elseif(file_exists('assets/clanImgs/'.$clan->id.'.jpg'))
                        <a href="#"><img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan->id.'.jpg')}}"
                            alt="Clan"></a>
                    @elseif(file_exists('assets/clanImgs/'.$clan->id.'.jpeg'))
                        <a href="#"><img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan->id.'.jpeg')}}"
                            alt="Clan"></a>
                    @else
                        <a href="#"><img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png') }}"
                            alt="Clan"></a>
                    @endif
                </div>
                <div class="col-sm-12 col-lg-7 my-2 text-left clan-bio">
                    <div class="text-left basic-info">
                        <h2><b>{{ $clan->name }}</b>
                            <button type="button" class="border-0 btn btn-default rounded-circle clan-help" data-toggle="tooltip" data-placement="auto" data-html="true">
                                <i class="fas fa-question-circle"></i>
                            </button>
                        </h2>
                        <p>{{ $clan->description }}</p>
                        @if($clan->owner()->get()[0]->id == Auth::user()->id)
                            <div class="my-2"><a class="no-hover standard-text" href="{{ url('/clanSettings') }}"><i
                                    class="fas fa-cog"></i> Settings</a></div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 my-2 text-left clan-info">
                    <div class="my-2"><i class="fas fa-user-cog"></i> Owner: <a href="/user/{{ $clan->owner()->get()[0]->username }}">{{ $clan->owner()->get()[0]->name }}</a></div>
                    <div class="my-2"><i class="fas fa-users"></i> Members: {{ $members->count() }}</div>
                     @if($clan->id == Auth::user()->clan()->get()[0]->id && !($clan->owner()->get()[0]->id == Auth::user()->id))
                        <button type="button" class="btn btn-danger mr-2" data-toggle="modal" data-target="#leaveClanModal">
                            Leave Clan <i class="fas fa-sign-out-alt"></i>
                        </button>
                    @endif
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
                <div class="text-center tab-pane fade active show" id="forum" role="tabpanel" aria-labelledby="forum-tab">
                    <div class="cardbox-comments align-items-center">
                        <button type="button" class="btn btn-lg btn-dark mr-2" data-toggle="modal" data-target="#postModal">
                            Create a new post
                        </button>
                        <button type="button" class="border-0 btn btn-default rounded-circle clan-feed-help" data-toggle="tooltip" data-placement="auto" data-html="true">
                                <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                    <!-- Modal -->
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
                                                    <input type="hidden" name="clan_id" value="{{$clan->id}}">
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
                    @if($posts->count() == 0)
                        <p class="text-center"><b><small>No posts to be seen!</small></b></p>
                    @else
                        <div id="posts-list">
                            @each('partials.post', $posts, 'post')
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" onkeyup="clanMembersSearch({{$clan->id}})" type="text" name="" placeholder="Search...">
                            <div class="search_icon"><i class="fas fa-search"></i></div>
                        </div>
                    </div>
                    <ul class="pl-0">
                        @each('partials.userList', $members->take(10), 'user')
                    </ul>
                </div>
                <div class="tab-pane fade" id="leaderboard" role="tabpanel" aria-labelledby="leaderboard-tab">
                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" onkeyup="clanLeaderboardSearch({{$clan->id}})" type="text" name="" placeholder="Search...">
                            <div class="search_icon"><i class="fas fa-search"></i></div>
                        </div>
                    </div>
                    <ol class="pl-0 shadow-lg">
                        @for ($i = 0; $i < min(8,$leaders->count()); $i++)
                            <button data-id="/user/{{ $leaders[$i]->username }}" type="button" class="text-left list-group-item border-0 list-group-item-action">
                                <li class="ml-3">
                                    <div class="d-flex align-items-center row">
                                        <div class="col-2 col-sm-1 friend-img">
                                            <img alt="logo" width="48" class="border img-fluid rounded-circle"
                                                src="{{ asset('assets/avatars/'.$leaders[$i]->race.'_'.$leaders[$i]->class.'_'.$leaders[$i]->gender.'.bmp') }}">
                                        </div>
                                        <div class="col-7 col-sm-6 text-left">{{ $leaders[$i]->name }}</div>
                                        <div class="col-1 offset-sm-1 col-sm-2 text-right">
                                            @if($i === 0)
                                                <img src="{{ asset('assets/first.png') }}" alt="logo">
                                            @elseif($i === 1)
                                                <img src="{{ asset('assets/second.png') }}" alt="logo">
                                            @elseif($i === 2)
                                                <img src="{{ asset('assets/third.png') }}" alt="logo">
                                            @endif
                                        </div>
                                        <div class="col-2 col-sm-2 text-right">
                                            {{ $leaders[$i]->xp }} XP
                                        </div>
                                    </div>
                                </li>
                            </button>
                        @endfor
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => Auth::user()->friends()->get() ])
</div>
<!-- Modal -->
<div class="modal fade" id="clan_helpModal" tabindex="-1" role="dialog" aria-labelledby="clan_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clan_helpModalLabel">Clan Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the clan page.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="leaveClanModal" tabindex="-1" role="dialog" aria-labelledby="leaveClanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaveClanModalLabel">Leave Clan</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure that you want to remove your Clan?</p>
                    <div class="float-right">
                        <button type="button" data-dismiss="modal" class="btn btn-success" onclick="window.location='{{ url('api/leaveClan/'.Auth::user()->id)}}'">Yes</button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger">No</button>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
    var start = 3;
    var working = false;
    $(window).scroll(function() {
        if ($(this).scrollTop() + 1 >= $('body').height() - $(window).height()) {
            if (working == false) {
                console.log("LOADING");
                working = true;
                $.ajax({
                    type: "GET",
                    url: "/api/seeMoreClan/"+start,
                    processData: false,
                    contentType: "application/json",
                    data: '',
                    success: function(ret) {
                        ret.sort(function(a, b) {
                            return a[1]['date'] < b[1]['date'];
                        });
                        for (var i = start; i < start + 3, i < ret.length; i++) 
                        {
                            let cur_post = ret[i];
                            let post_img = document.querySelector('.cardbox-heading>.media>div>a>img');
                            let path =  post_img.getAttribute('src');
                            let path_header = path.substr(0, path.indexOf("/avatars/"));
                                
                            $('#posts-list').append( getPostHTML(cur_post[2][0],cur_post[1], path_header));
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