<li class="p-2 ml-3" data-id="{{$blocked->id}}">
    <div class="d-flex align-items-center row" >
        <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
            <img width="40" class="border bg-warning img-fluid rounded-circle border"
            src="{{asset('assets/avatars/'.$blocked->race.'_'.$blocked->class.'_'.$blocked->gender.'.bmp')}} alt="Clan">
        </div>
        <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../user/{{$blocked->username}}">{{$blocked->name}}</a></div>
        <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
        <button type="button" class="unban_member btn btn-success btn-sm" id="{{$blocked->id}}">
                <i class="fas fa-user-plus"></i> Unban Member
        </button>
        </div>
    </div>
</li>