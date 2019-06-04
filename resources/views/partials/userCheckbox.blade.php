<li class="invite-list-user p-2 ml-3" data-id="{{ $user->id }}">
    <div class="d-flex align-items-center row">
        <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
            <img width="40" class="border img-fluid rounded-circle border" alt="User"
                src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}">
        </div>
        <div class="col-7 col-sm-6 col-md-7 pr-1 text-left">
            <a class="no-hover standard-text" href="user/{{ $user->username }}">
                {{ $user->name }}
            </a>
        </div>
        <div class="col-2 col-sm-3 col-md-3 px-0 text-right">
            <input type="checkbox">
            <span class="checkmark"></span>
        </div>
    </div>
</li>