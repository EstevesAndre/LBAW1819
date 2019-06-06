@extends('layouts.app')

@section('pageTitle', 'Home')

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
                <div class="infinite-scroll">
                    <div id="posts-list">
                        @foreach($posts as $p)
                            @if($p->id != null)
                                @include('partials.post', ['post' => $p])
                            @else
                                @include('partials.share', ['share' => $p])
                            @endif
                        @endforeach
                    </div>
                   {{-- {{$posts->links()}} --}}
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script type="text/javascript">
    var start = 3;
    var working = false;
    $(window).scroll(function() {
        console.log("Entrei");
            if ($(this).scrollTop() + 1 >= $('body').height() - $(window).height()) {
                console.log("Same");
                    if (working == false) {
                            working = true;
                            $.ajax({
                                    type: "GET",
                                    url: "/api/seeMoreHome/"+start,
                                    processData: false,
                                    contentType: "application/json",
                                    data: '',
                                    success: function(r) {
                                            // r = JSON.parse(r);
                                            
                                            for (var i = 0; i < r.posts.length; i++) {
                                                
                                                let cur_post = r.posts[i];
                                                let like_count = r.likes[i];
                                                let comment_count = r.comments[i];
                                                let share_count =r. shares[i];
                                                let post_owner = r.users[i];
                                                console.log(cur_post);
                                                if(cur_post.id != null){ //load posts
                                                    $('#posts-list').append("<div><h1>DEU LOAD DO POST</h1></div>")
                                                 }
                                                 else{ //load shares
                                                    $('#posts-list').append("<div><h1>DEU LOAD DO SHARE</h1></div>")
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
    })
</script>
 -->
