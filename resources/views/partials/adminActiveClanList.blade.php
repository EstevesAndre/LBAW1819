<li class="p-2 ml-3" data-id="{{ $clan->id }}">
    <div class="d-flex align-items-center row">
        <div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">
            @if(file_exists('assets/clanImgs/'.$clan->id.'.png'))
            <img width="50" class="border img-fluid rounded-circle border" alt="Clan"
                src="{{ asset('assets/clanImgs/'.$clan->id.'.png') }}">
            @elseif(file_exists('assets/clanImgs/'.$clan->id.'.jpg'))
            <img width="50" class="border img-fluid rounded-circle border" alt="Clan"
                src="{{ asset('assets/clanImgs/'.$clan->id.'.jpg') }}">
            @elseif(file_exists('assets/clanImgs/'.$clan->id.'.jpeg'))
            <img width="50" class="border img-fluid rounded-circle border" alt="Clan"
                src="{{ asset('assets/clanImgs/'.$clan->id.'.jpeg') }}">
            @else
            <img width="50" class="border img-fluid rounded-circle border" alt="Clan"
                src="{{ asset('assets/logo.png') }}">
            @endif
        </div>
        <div class="col-6 col-sm-5 col-md-6 pr-1 text-left">
            <a class="no-hover standard-text" href="{{ url('clan/'.$clan->id) }}">
            {{ $clan->name }}
            </a>
        </div>
        <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
            <button type="button" class="ban_clan btn btn-danger btn-sm" id="{{ $clan->id }}" data-toggle="modal" data-target="#clanBanModal">
                <i class="fas fa-user-times"></i> Ban Clan
            </button>
        </div>
    </div>
</li>