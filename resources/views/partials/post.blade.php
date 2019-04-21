<div class="container post mt-4 mb-3 p-0">
    <div class="cardbox text-left shadow-lg bg-white">
        <div class="cardbox-heading">
            <div class="dropdown float-right mt-3 mr-3">
                <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                    <a class="dropdown-item" href="#">Hide post</a> <!-- CHANGE -->
                    <a class="dropdown-item" href="#">Report</a> <!-- CHANGE -->
                </div>
            </div>
            <div class="media m-0">
                <div class="d-flex m-3">
                    <a href="/user/{{ $post->userID }}"><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}" alt="User"></a> <!-- CHANGE user IMG-->
                </div>
                <div class="media-body ml-1 align-self-center">
                    <a href="/user/{{ $post->userID }}"><p class="text-dark m-0">{{ $post->id }}...</p></a> <!-- CHANGE username -->
                    <!-- <small><span><i class="icon ion-md-pin mb-0"></i>Porto, Portugal</span></small> -->
                    <small><span><i class="icon ion-md-time mt-0"></i>{{ $post->date }} ... 10 hours ago</span></small> <!-- CHANGE date -->
                </div>
            </div>
        </div>
        <div class="cardbox-item mx-3">
            <p>{{ $post->content }}</p>
        </div>

        <!-- Still hardcoded (needs more views and connection to database) -->
        <div class="cardbox-base">
            <ul class="mx-3 mb-1">
                <!-- @each('partials.postLikes') -->
                <li><a><i class="fa fa-thumbs-up"></i></a></li>
                <li><a href="/user/{{ $post->userID }}"><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-success"
                            alt="User"></a></li>
                <li><a href="/user/{{ $post->userID }}"><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-danger"
                            alt="User"></a></li>
                <li><a href="/user/{{ $post->userID }}"><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-info"
                            alt="User"></a></li>
                <li><a href="/user/{{ $post->userID }}"><img src="{{ asset('assets/logo.png') }}" class="img-fluid rounded-circle bg-warning"
                            alt="User"></a></li>
                <li><a><span>12 Likes</span></a></li>
            </ul>
            <ul class="mx-3 mt-2">
                <li><a href="../pages/post.html"><i class="fa fa-comments"></i></a></li>
                <li><a><em class="mr-5">12</em></a></li>
                <li><a href="../pages/post.html"><i class="fa fa-share-alt"></i></a></li>
                <li><a><em class="mr-3">03</em></a></li>
            </ul>
        </div>
        <div class="cardbox-comments d-flex align-items-center">
            <span class="comment-avatar float-left mr-2">
                <a href="/user/{{ $post->userID }}">
                    <img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar">  <!-- CHANGE -->
                </a>
            </span>
            <div class="search-comment">
                <input placeholder="Write a comment..." type="text">
                <button><i class="fas fa-share-square"></i></button>
            </div>
        </div>
    </div>
</div>