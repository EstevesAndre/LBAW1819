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
                        @if($owner->id == Auth::user()->id)
                            <div class="my-2"><a class="no-hover standard-text" href="{{ url('/clanSettings') }}"><i
                                    class="fas fa-cog"></i> Settings</a></div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 my-2 text-left clan-info">
                    <div class="my-2"><i class="fas fa-globe"></i> Rank: 0</div>
                    <div class="my-2"><i class="fas fa-user-cog"></i> Owner: {{ $owner->name }}</div>
                    <div class="my-2"><i class="fas fa-users"></i> Members: {{ count($members) }}</div>
                </div>
            </div>
        </div>
        <button type="button" class="float-right border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#clan_helpModal">
                <i class="fas fa-question-circle"></i>
        </button>
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
                    <div class="cardbox-comments d-flex align-items-center">
                        <button type="button" class="btn btn-dark mr-2" data-toggle="modal" data-target="#postModal">
                            Create a new Post
                        </button>
                        <div class="search-comment" data-toggle="modal" data-target="#postModal">
                            <input placeholder="  New publication..." type="text" class="w-100">
                        </div>
                        <button type="button" class="border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#home_helpModal">
                                <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="postModalLabel">{{ $clan->name }} - Create Post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="clanID" value="{{ $clan->id }}">
                                    <div class="row align-items-center w-100 mx-2">
                                        <div class="col-sm-12 col-md-4 mt-3">
                                            <a href="/user/{{ Auth::user()->username }}"><img width="125" class="img-fluid border rounded-circle mb-3" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE -->
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
                        @for ($i = 0; $i < min(8,count($leaders)); $i++)
                            <button data-id="/user/{{ $leaders[$i]->username }}" type="button" class="text-left list-group-item border-0 list-group-item-action">
                                <li class="ml-3">
                                    <div class="d-flex align-items-center row">
                                        <div class="col-2 col-sm-1 friend-img">
                                            <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border bg-danger img-fluid rounded-circle">
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
                        @if(count($leaders) > 8)
                            <p class="text-center py-2 bg-white standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => $friends])
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
@endsection