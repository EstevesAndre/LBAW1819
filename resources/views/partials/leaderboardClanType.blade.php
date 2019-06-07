<div class="leaders mb-5 row mx-1">
    @if(count($clans) >= 2)
        <div class="second-place">
            <img src="{{ asset('assets/silver.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">
                @if(file_exists('assets/clanImgs/'.$clans[1][0]->id.'.png'))
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clans[1][0]->id.'.png')}}" alt="Clan">
                @else
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png')}}" alt="Clan">
                @endif
                <p class="m-0">{{ $clans[1][0]->name }}</p>     
                <p>{{ $clans[1][1] }} XP</p> 
            </div>
        </div>
    @endif
    @if(count($clans) >= 1)
        <div class="first-place">
            <img src="{{ asset('assets/gold.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">     
                @if(file_exists('assets/clanImgs/'.$clans[0][0]->id.'.png'))
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clans[0][0]->id.'.png')}}" alt="Clan">
                @else
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png')}}" alt="Clan">
                @endif
                <p class="m-0">{{ $clans[0][0]->name }}</p>     
                <p>{{$clans[0][1] }} XP</p> 
            </div>
        </div>
    @endif
    @if(count($clans) >= 3)
        <div class="third-place">
            <img src="{{ asset('assets/bronze.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">
                @if(file_exists('assets/clanImgs/'.$clans[2][0]->id.'.png'))
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clans[2][0]->id.'.png')}}" alt="Clan">
                @else
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/logo.png')}}" alt="Clan">
                @endif
                <p class="m-0">{{ $clans[2][0]->name }}</p>     
                <p>{{ $clans[2][1] }} XP</p> 
            </div>
        </div>
    @endif
</div>

@if(count($clans) > 3)
    <div class="d-flex justify-content-center mb-3 mr-3">
        <div class="leaderboard_search searchbar">
            <input class="search_input search_input_fixed" onkeyup="{{ $function }}()" type="text" placeholder="Search...">
            <div class="search_icon"><i class="fas fa-search"></i></div>
        </div>
    </div>

    <ol start="4" class="list pl-0 shadow-lg">
        @each('partials.leaderboardClanElement', array_slice($clans,3,5), 'clan')
    </ol>
@endif