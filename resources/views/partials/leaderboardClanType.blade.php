<div class="leaders mb-5 row mx-1">
    @if($clan->count() >= 2)
        <div class="second-place">
            <img src="{{ asset('assets/silver.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan[1]->id.'.jpg')}}" alt="Clan">
                <p class="m-0">{{ $clan[1]->name }}</p>     
                <p>{{ $clan[1]->xp }} XP</p> 
            </div>
        </div>
    @endif
    @if($clan->count() >= 1)
        <div class="first-place">
            <img src="{{ asset('assets/gold.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">     
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan[0]->id.'.jpg')}}" alt="Clan">
                <p class="m-0">{{ $clan[0]->name }}</p>     
                <p>{{ $clan[0]->xp }} XP</p> 
            </div>
        </div>
    @endif
    @if($clan->count() >= 3)
        <div class="third-place">
            <img src="{{ asset('assets/bronze.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">     
                <img width="200" class="img-fluid border rounded-circle" src="{{ asset('assets/clanImgs/'.$clan[2]->id.'.jpg')}}" alt="Clan">
                <p class="m-0">{{ $clan[2]->name }}</p>     
                <p>{{ $clan[2]->xp }} XP</p> 
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
        @each('partials.leaderboardClanElement', $clan->slice(3,5), 'clan')
        @if($clan->count() > 3+5)
            <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
        @endif
    </ol>
@endif