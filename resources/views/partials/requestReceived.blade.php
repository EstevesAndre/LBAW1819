<li class="p-2 ml-3" data-id='{{ $request->id }}'>
    <div class="d-flex align-items-center row">
        <div class="col-2 col-sm-2 col-md-1 friend-img">
            <img width="40" class="border bg-warning img-fluid rounded-circle border" src="{{ asset('assets/logo.png') }}" alt="User">
        </div>
        <div class="col-5 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="/user/{{ $request }}">{{ $request }}</a></div>
        <div class="col-4 col-sm-4 col-md-4 px-0 text-right">
            <button type="button" class="btn btn-success btn-request">
                <i class="fas fa-check"></i> <span>Accept</span>
            </button>
            <button type="button" class="btn btn-danger btn-request">
                <i class="fas fa-times"></i> <span>Decline</span>
            </button>
        </div>
    </div>
</li>