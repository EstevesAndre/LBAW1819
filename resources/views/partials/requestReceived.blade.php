<li class="friend-answer-rp p-2 ml-3" data-id='{{ $request->sender()->get()[0]->id }}'>
    <div class="d-flex align-items-center row">
        <div class="col-2 col-sm-2 col-md-1 friend-img">
            <img width="40" class="border bg-warning img-fluid rounded-circle border" src="{{ asset('assets/avatars/'.$request->sender()->get()[0]->race.'_'.$request->sender()->get()[0]->class.'_'.$request->sender()->get()[0]->gender.'.bmp') }}" alt="User">
        </div>
        <div class="col-5 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="/user/{{ $request->sender()->get()[0]->username }}">{{$request->sender()->get()[0]->name }}</a></div>
        <div class="col-4 col-sm-4 col-md-4 px-0 text-right">
            <button type="button" class="friend-accept w-50 col-sm-12 mt-5 btn btn-success" data-id="{{$request->sender()->get()[0]->id}}"> 
                Accept <i class="fas fa-check"></i>
            </button>
            <button type="button" class="friend-decline w-50 col-sm-12 mt-2 btn btn-danger" data-id="{{$request->sender()->get()[0]->id}}">   
                Decline <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</li>