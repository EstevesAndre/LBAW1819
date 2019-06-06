<li class="friend-cancel-rp py-2 px-2 ml-3" data-id='{{ $request->receiver()->get()[0]->id}}'>
    <div class="d-flex align-items-center row">
        <div class="pl-3 col-2 col-sm-2 col-md-1 friend-img">
            <img width="60" class="border bg-warning img-fluid rounded-circle border" src="{{ asset('assets/avatars/'.$request->receiver()->get()[0]->race.'_'.$request->receiver()->get()[0]->class.'_'.$request->receiver()->get()[0]->gender.'.bmp') }}" alt="User">
        </div>
        <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="/user/{{ $request->receiver()->get()[0]->username}}">{{ $request->receiver()->get()[0]->name}}</a></div>
        <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
            <button type="button" class="friend-cancel col-sm-12 btn btn-danger" data-id="{{$request->receiver()->get()[0]->id}}">
                Cancel Request <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</li>