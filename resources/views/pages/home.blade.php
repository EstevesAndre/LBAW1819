@extends('layouts.app')

@section('pageTitle', 'Home')

@section('content')
<br />
<div class="mt-5 pt-3 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 activity">
        <div class="cardbox-comments align-self-center">
            <button type="button" class="btn btn-lg btn-dark mr-2" data-toggle="modal" data-target="#postModal">
                Create a new post
            </button>
            <button type="button" class="border-0 btn btn-default rounded-circle feed-help" data-toggle="tooltip" data-placement="auto" data-html="true">
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
        <!-- POSTS -->
        <section id="posts" data-count="1">
            @if($posts->count() == 0)
                <p class="text-center"><b><small>No posts to be seen!</small></b></p>
            @else
                <div class="infinite-scroll">
                    <div id="posts-list">
                        @foreach($posts as $p)
                            @if($p->id !== null)
                                @if($p->clan_id == null || (!Auth::user()->clan()->get()->isEmpty() && $p->clan_id == Auth::user()->clan()->get()[0]->id))
                                    @include('partials.post', ['post' => $p])
                                @endif
                            @else
                                @include('partials.share', ['share' => $p])
                            @endif
                        @endforeach
                    </div>
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
        if ($(this).scrollTop() + 1 >= $('body').height() - $(window).height()) {
            if (working == false) {
                console.log("LOADING");
                working = true;
                $.ajax({
                    type: "GET",
                    url: "/api/seeMoreHome/"+start,
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