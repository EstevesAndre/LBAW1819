@extends('layouts.app')

@section('content')

<br />
<div class="modal postModal fade" id="deletePostModal-{{ $post->id }}" data-id="{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="removePostModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removePostModalLabel">Delete post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-left">Are you sure you want to delete this post?</p>
                <div class="float-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Yes</span>
                    </button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">No</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal shareModal fade" id="sharePostModal-{{ $post->id }}" data-id="{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="removePostModalLabel" aria-hidden="true">
    <div class="modal-dialog align-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removePostModalLabel">Share post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/api/share/{{$post->id}}">
                    {{csrf_field()}}
                    <textarea class="rounded border-secondary w-100" rows="4" placeholder="Write your share message..." name="content"></textarea>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success">Share</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="mt-5 row text-center fullscreen-3-4 m-0 standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 activity">
        <!-- POST -->
        <div class="post container post mt-4 mb-2 p-0" data-id="{{ $post->id }}">
            <div class="cardbox text-left shadow-lg bg-white">
                <div class="cardbox-heading">
                    <div class="dropdown float-right mt-3 mr-3">
                        <button type="button" class="float-right border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#post_helpModal">
                                <i class="fas fa-question-circle"></i>
                        </button>
                        <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                            <a class="dropdown-item" href="#">Hide post</a>
                            <a class="dropdown-item" href="#">Report</a>
                            @if($post->user_id == Auth::user()->id)
                                <a class="dropdown-item" data-toggle="modal" data-target="#deletePostModal-{{ $post->id }}">Delete</a>
                            @endif
                        </div>
                    </div>
                    <div class="media m-0">
                        <div class="d-flex m-3">
                            <a href="/user/{{ $post->user()->get()[0]->username }}"><img class="img-fluid rounded-circle" 
                                src="{{ asset('assets/avatars/'.$post->user()->get()[0]->race.'_'.$post->user()->get()[0]->class.'_'.$post->user()->get()[0]->gender.'.bmp') }}"
                                    alt="User"></a>
                        </div>
                        <div class="media-body ml-1 align-self-center">
                            <p class="text-dark m-0 user-link">
                                <a class="user-link" href="/user/{{ $post->user()->get()[0]->username }}">
                                    {{ $post->user()->get()[0]->name }}
                                </a>
                            </p>
                            <small><span><i class="icon ion-md-time mt-0"></i>{{ substr($post->date, 0, 19) }}</span></small>
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
                        <li><a data-toggle="modal" data-target="#sharePostModal-{{ $post->id }}"><i class="fa fa-share-alt"></i></a></li>
                        <li><a><em class="mr-3">{{ $post->share()->count() }}</em></a></li>
                    </ul>
                </div>
                <div class="cardbox-comments d-flex align-items-center">
                    <span class="comment-avatar float-left mr-2">
                        <a href="/user/{{ Auth::user()->username }}"><img class="rounded-circle" 
                            src="{{ asset('assets/avatars/'.Auth::user()->race.'_'.Auth::user()->class.'_'.Auth::user()->gender.'.bmp') }}"
                            alt="Avatar"></a>
                    </span>
                    <div class="search-comment">
                        <input placeholder="Write a comment..." type="text">
                        <button><i class="fas fa-share-square"></i></button>
                    </div>
                </div>
                <div class="container comments">
                    @each('partials.comment', $post->comment()->orderBy('date','desc')->skip(0)->take(7)->get() , 'comment')
                </div>
                @if($post->comment()->count() > 7)
                    <p class="text-center py-2 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                @endif
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => Auth::user()->friends() ])
</div>
<div class="modal fade" id="post_helpModal" tabindex="-1" role="dialog" aria-labelledby="post_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="post_helpModalLabel">Post Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the post page.
            </div>
        </div>
    </div>
</div>
@endsection