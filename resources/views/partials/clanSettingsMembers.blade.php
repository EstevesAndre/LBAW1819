<li class="p-2 ml-3">
        <div class="d-flex align-items-center row">
            <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
                <img width="40" class="border bg-warning img-fluid rounded-circle border"
                    src="{{asset('assets/avatars/'.$member->race.'_'.$member->class.'_'.$member->gender.'.bmp')}}" alt="Member">
            </div>
            <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../user/{{$member->username}}">{{$member->name}}</a></div>
            <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                <button type="button" class="ban_member btn btn-danger btn-sm" id="{{$member->id}}" data-toggle="modal"
                    data-target="#banModal">
                    <i class="fas fa-user-times"></i> Ban Member
                </button>
            </div>
        </div>
    </li>