<li class="p-2 ml-4" data-id="{{$user->id}}">
    <div class="d-flex align-items-center row">
        <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
            <img width="50" class="border img-fluid rounded-circle" alt="Clan"
            src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}">
        </div>
        <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="user/{{ $user->username}}">{{ $user->name }}</a></div>
        <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
            @if($user->id == Auth::user()->id)
                <button type="button" class="ban_user btn btn-danger btn-sm" disabled>
            @else
                <button type="button" class="ban_user btn btn-danger btn-sm" data-id="{{ $user->id }}" data-toggle="modal" data-target="#banModal">
            @endif
                <i class="fas fa-user-times"></i> Ban User
            </button>
        </div>
    </div>
</li>