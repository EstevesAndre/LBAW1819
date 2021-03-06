<li class="list-group shadow-lg">
    <button data-id="/user/{{ $user->username }}" type="button" class="text-left list-group-item list-group-item-action">
        <div class="d-flex align-items-center row">
            <div class="col-2 col-sm-1 friend-img">
                <img width="50" src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}" 
                alt="logo" class="border bg-warning img-fluid rounded-circle">
            </div>
            <div class="col-5 col-sm-6 pr-1">{{ $user->name }}</div>
            <div class="col-5 col-sm-5 pl-1 text-right">{{ $user->date }}</div>
        </div>
    </button>
</li>