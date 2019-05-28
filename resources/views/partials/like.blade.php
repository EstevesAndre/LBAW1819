<li>
    <a href="/user/{{ $like->user()->get()[0]->username }}">
        <img src="{{ asset('assets/avatars/'.$like->user()->get()[0]->race.'_'.$like->user()->get()[0]->class.'_'.$like->user()->get()[0]->gender.'.bmp') }}" 
         class="img-fluid rounded-circle bg-success" alt="user">
    </a>
</li>