<div class="d-flex align-items-center" id="{{ $comment->id}}">
    <span class="comment-avatar float-left mr-2">
        <a href="/user/{{ $comment->user()->get()[0]->username }}">
            <img class="img-fluid border rounded-circle" 
            src="{{ asset('assets/avatars/'.$comment->user()->get()[0]->race.'_'.$comment->user()->get()[0]->class.'_'.$comment->user()->get()[0]->gender.'.bmp') }}"
            alt="User"></a>
    </span>
    <div class="comment-data pl-1 pr-0">
        <p class="pt-3">{{ $comment->comment_text }}</p>
    </div>
    <span class="delete-comment">
        <a><i class="fas fa-times"></i></a>
    </span>
</div>