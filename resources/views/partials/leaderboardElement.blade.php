<button data-id="/user/{{ $user->username }}" type="button" class="text-left list-group-item border-0 list-group-item-action">
    <li class="ml-3">
        <div class="d-flex align-items-center row">
            <div class="col-2 col-sm-1 friend-img">
                <img src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}" alt="logo"
                    class="border bg-light img-fluid rounded-circle">
            </div>
            <div class="col-7 col-sm-6 text-left">{{ $user->name }}</div>
            <div class="col-3 col-sm-5 text-right">{{ $user->xp }}</div>
        </div>
    </li>
</button>