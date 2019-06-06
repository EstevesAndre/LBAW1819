<li class="friend-answer-rp p-2 ml-3" data-id='{{ $clan->clan_id }}'>
    <div class="d-flex align-items-center row">
        <div class="col-2 col-sm-2 col-md-1 friend-img">
            @if(file_exists('assets/clanImgs/'.$clan->clan_id.'.png'))
                <img width="60" class="border img-fluid rounded-circle" src="{{ asset('assets/clanImgs/'. $clan->clan_id.'.png') }}" alt="Clan">
            @else
                <a href="#"><img width="100" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png') }}" alt="Clan"></a>
            @endif
        </div>
        <div class="col-5 col-sm-5 col-md-6 pr-1 text-left"><h3>{{$clan->clan()->get()[0]->name}}</h3></div>
        <div class="col-4 col-sm-4 col-md-4 px-0 text-right">
            @if(Auth::user()->clan()->get()->isEmpty())
            <button type="button"  class="clan-accept col-sm-12 mb-1 btn btn-success" data-id="{{$clan->clan_id}}"> 
                Join Clan <i class="fas fa-check"></i>
            </button>
            <button type="button"  class="clan-decline col-sm-12 mt-1 btn btn-danger" data-id="{{$clan->clan_id}}">   
                Decline <i class="fas fa-times"></i>
            </button>
            @else
            <button type="button" class="clan-accept col-sm-12 mb-1 btn btn-success" data-id="{{$clan->clan_id}}" disabled> 
                Join Clan <i class="fas fa-check"></i>
            </button>
            <button type="button" class="clan-decline col-sm-12 mt-1 btn btn-danger" data-id="{{$clan->clan_id}}" disabled>   
                Decline <i class="fas fa-times"></i>
            </button>
            @endif
        </div>
    </div>
</li>