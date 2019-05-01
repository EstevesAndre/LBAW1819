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
                    <a href="/user/{{ $post->user_id }}"><img class="img-fluid rounded-circle" src="{{ asset('assets/logo.png') }}"
                            alt="User"></a>
                </div>
                <div class="media-body ml-1 align-self-center">
                    <a href="/user/{{ $post->user_id }}">
                        <p class="text-dark m-0">{{ $post->user()->get()[0]->name }}</p>
                    </a>
                    <small><span><i class="icon ion-md-time mt-0"></i>{{ $post->date }}</span></small>
                </div>
            </div>
        </div>
        <div class="cardbox-item mx-3">{{ $post->content }}</div>
        <div class="cardbox-base">
            <ul class="mx-3 mb-1">
                @if(count($post->like()->where('user_id','=',Auth::user()->id)->get()) == 0)
                    <li><a><i class="fa fa-thumbs-up"></i></a></li>
                @else
                    <li><a><i class="fa fa-thumbs-up active"></i></a></li>
                @endif
                @each('partials.like', $post->like()->take(4)->get(), 'like')
                <li><a><span>{{ $post->like()->count() }}</span></a></li>
            </ul>
            <ul class="mx-3 mt-2">
                <li><a><i class="fa fa-comments"></i></a></li> <!-- Add action to comment and like -->
                <li><a><em class="mr-5">{{ $post->comment()->count() }}</em></a></li>
                <li><a><i class="fa fa-share-alt"></i></a></li>
                <li><a><em class="mr-3">{{ $post->share()->count() }}</em></a></li>
            </ul>
        </div>
        <div class="cardbox-comments d-flex align-items-center">
            <span class="comment-avatar float-left mr-2">
                <a href="/user/{{ $post->user_id }}"><img class="rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Avatar"></a>
            </span>
            <div class="search-comment">
                <input placeholder="Write a comment..." type="text">
                <button><i class="fas fa-share-square"></i></button>
            </div>
        </div>
    </div>
</div>