<li class="p-2 ml-3" data-id="{{$clan->id}}">
    <div class="d-flex align-items-center row">
        <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
            <img width="50" class="border img-fluid rounded-circle border" alt="Clan"
                src="{{ asset('assets/clanImgs/'.$clan->id.'.png') }}">
        </div>
        <div class="col-6 col-sm-5 col-md-6 pr-1 text-left">
            {{ $clan->name }}
        </div>
        <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
            <button type="button" class="unban_clan btn btn-success btn-sm" data-id="{{ $clan->id }}" value="{{ $clan->ban()->get()[0]->date }}" data-toggle="modal" data-target="#clanUnbanModal">
                <i class="fas fa-user-times"></i> Unban Clan
            </button>
        </div>
    </div>
</li>