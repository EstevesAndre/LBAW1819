<div class="modal shareModal fade" id="sharePostModal-{{ $share->post()->get()[0]->id }}" data-id="{{ $share->post()->get()[0]->id }}" tabindex="-1" role="dialog" aria-labelledby="removePostModalLabel" aria-hidden="true">
    <div class="modal-dialog align-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removePostModalLabel">Share post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/api/share/{{$share->post()->get()[0]->id}}">
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
@if($share->user_id == Auth::user()->id || Auth::user()->is_admin)
    <div class="modal sharedPostModal fade" id="deleteShareModal-{{ $share->post()->get()[0]->id }}-{{ $share->user()->get()[0]->id }}" data-id="{{ $share->post()->get()[0]->id }}-{{ $share->user()->get()[0]->id }}" tabindex="-1" role="dialog" aria-labelledby="removeShareModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeShareModalLabel">Delete share</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-left">Are you sure you want to delete this share?</p>
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
<div class="container share mt-4 mb-2 p-0" data-id="{{ $share->post()->get()[0]->id }}-{{ $share->user()->get()[0]->id }}">
    <div class="cardbox text-left shadow-lg bg-white">
        <div class="cardbox-heading">
            <div class="dropdown float-right mt-3 mr-3">
                <button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                <div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">
                    @if($share->user_id == Auth::user()->id || Auth::user()->is_admin)
                        <a class="dropdown-item" data-toggle="modal" data-target="#deleteShareModal-{{ $share->post()->get()[0]->id }}-{{ $share->user()->get()[0]->id }}">Delete</a>
                    @endif
                </div>
            </div>
            <div class="media m-0">
                <div class="d-flex m-3">
                    <a class="mx-1 my-1" href="/user/{{ $share->user()->get()[0]->username }}">
                        <img class="img-fuild rounded-circle" 
                            src="{{ asset('assets/avatars/'.$share->user()->get()[0]->race.'_'.$share->user()->get()[0]->class.'_'.$share->user()->get()[0]->gender.'.bmp') }}" 
                        alt="User">
                    </a>
                </div>
                <div class="media-body ml-1 align-self-center">
                    <p class="text-dark m-0 user-link">
                        <a class="user-link" href="/user/{{ $share->user()->get()[0]->username }}">
                            {{ $share->user()->get()[0]->name }}
                        </a>
                         shared a post from 
                        <a class="user-link" href="/user/{{ $share->post()->get()[0]->user()->get()[0]->username }}">
                            {{ $share->post()->get()[0]->user()->get()[0]->name }}
                        </a>
                    </p>
                    <small><span><i class="icon ion-md-time mt-0"></i>{{ substr($share->date, 0, 19) }}</span></small>
                </div>
            </div>
        </div>
        <a class="box-link no-hover" href="/share/{{ $share->post()->get()[0]->id }}_{{ $share->user()->get()[0]->id }}"><div class="cardbox-item mx-3 mb-2">{{ $share->content }}</div></a>
        
        <a class="box-link no-hover" href="/post/{{ $share->post()->get()[0]->id }}">
            @include('partials.post', ['post' => $share->post()->get()[0]])
        </a>
    </div>
</div>