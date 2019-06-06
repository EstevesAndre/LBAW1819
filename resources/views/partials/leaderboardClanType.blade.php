{{$clans[1]->xp}}
{{-- <div class="leaders mb-5 row mx-1">
    @if($clans->count() >= 2)
        <div class="second-place">
            <img src="{{ asset('assets/silver.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">
                @if(file_exists('assets/clanImgs/'.$clans[1].clan->id.'.png'))
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clans[1].clan->id.'.png')}}" alt="Clan">
                @else
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png')}}" alt="Clan">
                @endif
                <p class="m-0">{{ $clans[1].clan->name }}</p>     
                <p>{{ $clans[1].xp) }} XP</p> 
            </div>
        </div>
    @endif
    @if($clans->count() >= 1)
        <div class="first-place">
            <img src="{{ asset('assets/gold.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">     
                @if(file_exists('assets/clanImgs/'.$clans[0]->pull('clan')->id.'.png'))
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clans[0]->pull('clan')->id.'.png')}}" alt="Clan">
                @else
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png')}}" alt="Clan">
                @endif
                <p class="m-0">{{ $clans[0]->pull('clan')->name }}</p>     
                <p>{{ $clans[0]->pull('xp') }} XP</p> 
            </div>
        </div>
    @endif
    @if($clans->count() >= 3)
        <div class="third-place">
            <img src="{{ asset('assets/bronze.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">
                @if(file_exists('assets/clanImgs/'.$clans[2]->pull('clan')->id.'.png'))
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clans[2]->pull('clan')->id.'.png')}}" alt="Clan">
                @else
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png')}}" alt="Clan">
                @endif
                <p class="m-0">{{ $clans[2]->pull('clan')->name }}</p>     
                <p>{{ $clans[2]->pull('xp') }} XP</p> 
            </div>
        </div>
    @endif
</div>

@if($clan->count() > 3)
    <div class="d-flex justify-content-center mb-3 mr-3">
        <div class="leaderboard_search searchbar">
            <input class="search_input search_input_fixed" onkeyup="{{ $function }}()" type="text" name="" placeholder="Search...">
            <div class="search_icon"><i class="fas fa-search"></i></div>
        </div>
    </div>

    <ol start="4" class="list pl-0 shadow-lg">
        @each('partials.leaderboardClanElement', $clans->slice(3,5), $clan)
        @if($clans->count() > 3+5)
            <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
        @endif
    </ol>
@endif --}}