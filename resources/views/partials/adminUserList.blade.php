{{-- <li class="p-2 ml-4">
    <div class="d-flex align-items-center row">
        <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
            <img width="50" class="border img-fluid rounded-circle" alt="Clan"
            src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}">
        </div>
        <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="user/{{ $user->username}}">{{ $user->name }}</a></div>
        <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#banModal">
                <i class="fas fa-user-times"></i> Ban User
            </button>
        </div>
    </div>
</li> --}}
<p> 
    {{ $user->id }}
</p>