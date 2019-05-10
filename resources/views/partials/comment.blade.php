<div class="d-flex align-items-center" id="{{$comment->id}}">
    <span class="comment-avatar float-left mr-2">
        <a href="/user/{{ $comment->user_id }}"><img class="rounded-circle bg-warning" src="{{ asset('assets/logo.png') }}"
                alt="Avatar"></a>
    </span>
    <div class="comment-data pl-1 pr-0">
        <p class="pt-3">{{ $comment->comment_text }}</p>
    </div>
</div>