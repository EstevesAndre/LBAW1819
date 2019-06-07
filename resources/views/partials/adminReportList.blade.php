<li class="p-2 ml-4" data-id="report{{$report->id}}">
    <div class="d-flex align-items-center row">
        <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
            <img width="50" class="border img-fluid rounded-circle" alt="Clan"
            src="{{ asset('assets/avatars/'.$report->post()->get()[0]->user()->get()[0]->race.'_'.$report->post()->get()[0]->user()->get()[0]->class.'_'.$report->post()->get()[0]->user()->get()[0]->gender.'.bmp') }}">
        </div>
        <div class="col-6 col-sm-5 col-md-6 pr-1 text-left">
            <a class="no-hover standard-text" href="post/{{ $report->post()->get()[0]->id}}">Post </a>by
            <a class="no-hover standard-text" href="user/{{ $report->post()->get()[0]->user()->get()[0]->username}}"> {{ $report->post()->get()[0]->user()->get()[0]->name }}</a>
        </div>
        <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
            @if($report->post()->get()[0]->user()->get()[0]->ban()->get()->isEmpty() == Auth::user()->id)
                <button type="button" class="ban_user btn btn-danger btn-sm" id="{{ $report->post()->get()[0]->user()->get()[0]->id }}" data-toggle="modal" data-target="#banModal">
                <i class="fas fa-user-times"></i> Ban User
            @else
                <button type="button" class="ban_user btn btn-danger btn-sm" disabled>
                <i class="fas fa-user-times"></i> User Already Banned
            @endif
            </button>
            <button type="button" id="{{$report->id}}" class="dismiss btn btn-success btn-sm"><i class="fas fa-check"></i> Dismiss</button>
        </div>
    </div>
</li>