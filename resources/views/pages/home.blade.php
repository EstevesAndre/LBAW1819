@extends('layouts.app')

@section('content')
<br />
<div class="mt-5 pt-3 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 activity">
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
        <!-- POSTS -->
        <section id="posts" data-count="1">
            @if($posts->count() == 0)
                <p class="text-center"><b><small>No posts to be seen!</small></b></p>
            @else
                <div id="posts-list">
                    @each('partials.post', $posts->take(15), 'post')
                    {{-- @if($posts->count() > 15) --}}
                        <button type="button" class="see-more btn-primary-outline btn m-3">
                            See more <i class="fas fa-caret-down"></i>
                        </button>
                    {{-- @endif --}}
                </div>
            @endif
        </section>
    </div>
    @include('partials.chatSideBar', ['friends' => Auth::user()->friends()->get() ])
</div>

<!-- Modal -->
<div class="modal fade" id="home_helpModal" tabindex="-1" role="dialog" aria-labelledby="home_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="home_helpModalLabel">Feed Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the home pages.
            </div>
        </div>
    </div>
</div>
@endsection
