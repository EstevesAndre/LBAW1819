<div class="d-flex align-items-center comment my-2" id="{{ $comment->id}}">
    <span class="comment-avatar float-left mr-2">
        <a href="/user/{{ $comment->user()->get()[0]->username }}">
            <img class="img-fluid border rounded-circle" 
            src="{{ asset('assets/avatars/'.$comment->user()->get()[0]->race.'_'.$comment->user()->get()[0]->class.'_'.$comment->user()->get()[0]->gender.'.bmp') }}"
            alt="User"></a>
    </span>
    <div class="w-90 comment-data pl-1 pr-0">
        <p class="border pt-3">{{ $comment->comment_text }}</p>
    </div>
    @if($comment->post_id == Auth::user()->id || Auth::user()->is_admin || ($post->clan_id != null && $post->clan()->get()[0]->owner()->get()[0]->id == Auth::user()->id))
    <span class="ml-2 delete-comment" id="{{ $comment->id}}">
        <a><i class="fas fa-times"></i></a>
    </span>
    @endif
</div>