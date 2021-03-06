@if($post->user_id == Auth::user()->id || Auth::user()->is_admin || ($post->clan_id != null && $post->clan()->get()[0]->owner()->get()[0]->id == Auth::user()->id))
    <div class="modal postModal fade" id="deletePostModal-{{ $post->id }}" data-id="{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deletePostModalLabel-{{ $post->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePostModalLabel-{{ $post->id }}">Delete post</h5>
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
@endif

@if($post->clan_id === null) 
    <div class="modal shareModal fade" id="sharePostModal-{{ $post->id }}" data-id="{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="sharePostModalLabel-{{ $post->id }}" aria-hidden="true">
        <div class="modal-dialog align-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sharePostModalLabel-{{ $post->id }}">Share post</h5>
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
@endif

<div class="modal reportModal fade" id="reportPostModal-{{ $post->id }}" data-id="{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="reportPostModalLabel-{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog align-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportPostModalLabel-{{ $post->id }}">Report post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                    <p>Why are you reporting this post?</p>
                    <div class="form-check">
                        <input class="form-check-input" name="motive" type="radio" value="Inappropriate behaviour" id="defaultCheck1-{{ $post->id }}" required>Inappropriate behaviour
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="motive" type="radio" value="Abusive content" id="defaultCheck2-{{ $post->id }}" required>Abusive content
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="motive" type="radio" value="Racism" id="defaultCheck3-{{ $post->id }}" required>Racism
                    </div>
                <div class="float-right">
                    <button type="submit" data-dismiss="modal" class="report btn btn-danger">Report</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="report-success-{{ $post->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Report Sent!</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <p>Your report was successfully sent!</p>
                <p>Thank you for helping us make AlterEgo cleaner!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="report-repeated-{{ $post->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Report Error!</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <p>You already made a report about this post!</p>
                <p>Don't worry were already taking care of it!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>

<div class="container post mt-4 mb-2 p-0" data-id="{{ $post->id }}">
    <div class="cardbox text-left shadow-lg bg-white">
        <div class="cardbox-heading">
            <div class="dropdown float-right mt-3 mr-3">
                <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                        <a class="dropdown-item" data-toggle="modal" data-target="#reportPostModal-{{ $post->id }}">Report</a>
                    @if($post->user_id == Auth::user()->id || Auth::user()->is_admin)
                        <a class="dropdown-item" data-toggle="modal" data-target="#deletePostModal-{{ $post->id }}">Delete</a>
                    @endif
                </div>
            </div>
            <div class="media m-0">
                <div class="d-flex m-3">
                    <a class="mx-1 my-1" href="/user/{{ $post->user()->get()[0]->username }}">
                        <img class="img-fuild rounded-circle" 
                            src="{{ asset('assets/avatars/'.$post->user()->get()[0]->race.'_'.$post->user()->get()[0]->class.'_'.$post->user()->get()[0]->gender.'.bmp') }}" 
                        alt="User">
                    </a>
                </div>
                <div class="media-body ml-1 align-self-center">
                    <p class="text-dark m-0 user-link">
                        <a class="user-link" href="/user/{{ $post->user()->get()[0]->username }}">
                            {{ $post->user()->get()[0]->name }}
                        </a>
                        @if (!$post->clan()->get()->isEmpty())
                        <a class="user-link" href="/clan">
                            @ {{ $post->clan()->get()[0]->name }}
                        </a>
                        @endif
                    </p>
                    <small><span><i class="icon ion-md-time mt-0"></i>{{ substr($post->date, 0, 19) }}</span></small>
                </div>
            </div>
        </div>
        <a class="box-link no-hover" href="/post/{{ $post->id }}">
            <div class="cardbox-item mx-3 mb-2">{{ $post->content }}</div>
            @if($post->has_img)
                <div class="text-center">
                    <img class="img-posts" src="{{ asset('assets/postImgs/'.$post->id.'.png') }}" alt="Post Image">
                </div>
            @endif
        </a>
        <div class="cardbox-base text-center">
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
                @if($post->clan_id === null)
                    @if(count($post->share()->where('user_id','=',Auth::user()->id)->get()) == 0)
                        <li><a data-toggle="modal" data-target="#sharePostModal-{{ $post->id }}"><i class="fa fa-share-alt"></i></a></li>
                    @else
                        <li><a><i class="fa fa-share-alt active"></i></a></li>
                    @endif
                    <li><a><em class="mr-3">{{ $post->share()->count() }}</em></a></li>
                @endif
            </ul>
        </div>
    </div>
</div>