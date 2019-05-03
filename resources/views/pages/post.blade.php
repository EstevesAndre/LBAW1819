@extends('layouts.app')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen-3-4 m-0 standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 activity">
        <!-- POST -->
        <div class="container post mt-4 mb-2 p-0" data-id="{{ $post->id }}">
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
                            <a href="/user/{{ $post->user()->get()[0]->username }}"><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}"
                                    alt="User"></a>
                        </div>
                        <div class="media-body ml-1 align-self-center">
                            <p class="text-dark m-0 user-link">
                                <a class="user-link" href="/user/{{ $post->user()->get()[0]->username }}">
                                    {{ $post->user()->get()[0]->name }}
                                </a>
                            </p>
                            <small><span><i class="icon ion-md-time mt-0"></i>{{ $post->date }}</span></small>
                        </div>
                    </div>
                </div>
                <div class="cardbox-item mx-3">{{ $post->content }}</div>
                <div class="cardbox-base">
                    <ul class="fst mx-3 mb-1">
                        @if(count($post->like()->where('user_id','=',Auth::user()->id)->get()) == 0)
                            <li><a><i class="fa fa-thumbs-up"></i></a></li>
                        @else
                            <li><a><i class="fa fa-thumbs-up active"></i></a></li>
                        @endif
                        @each('partials.like', $post->like()->take(4)->get(), 'like')
                        <li><a><span>{{ $post->like()->count() }}</span></a></li>
                    </ul>
                    <ul class="scd mx-3 mt-2">
                        <li><a><i class="fa fa-comments"></i></a></li> <!-- Add action to comment and like -->
                        <li><a><em class="mr-5">{{ $post->comment()->count() }}</em></a></li>
                        <li><a><i class="fa fa-share-alt"></i></a></li>
                        <li><a><em class="mr-3">{{ $post->share()->count() }}</em></a></li>
                    </ul>
                </div>
                <div class="cardbox-comments d-flex align-items-center">
                    <span class="comment-avatar float-left mr-2">
                        <a href="/user/{{ Auth::user()->id }}"><img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar"></a>
                    </span>
                    <div class="search-comment">
                        <input placeholder="Write a comment..." type="text">
                        <button><i class="fas fa-share-square"></i></button>
                    </div>
                </div>
                <div class="container">
                    @each('partials.comment', $post->comment()->orderBy('date','desc')->skip(0)->take(7)->get() , 'comment')
                </div>
                @if($post->comment()->count() > 7)
                    <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-3 bg-light side-bar side">
        @if(count($friends) == 0) 
            <p class="text-center"><small>Add a friend to chat with him!</small></p>
        @else
            <div class="d-flex justify-content-center">
                <div class="searchbar searchbar-fixed">
                    <input class="search_input search_fixed" type="text" name="" placeholder="Search...">
                    <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                </div>
            </div>
            <div class="height-45 scroolable">
                <div class="list-group text-left" id="list-tab" role="tablist">
                    @each('partials.chatFriend', array_slice($friends,0,15), 'user')
                    @if(count($friends) > 15)
                        <p class="text-center list-group-item p-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                    @endif
                </div>
            </div>
        @endif
        <div class="border-left height-45">
            <div class="py-3 px-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
                @each('partials.chatFriendSelected', array_slice($friends,0,15), 'user')
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