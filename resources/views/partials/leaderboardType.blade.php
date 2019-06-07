<div class="leaders mb-5 row mx-1">
    @if($collection->count() >= 2)
        <div class="second-place">
            <img src="{{ asset('assets/silver.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium" data-id="/user/{{ $collection[1]->username }}">
                <img src="{{ asset('assets/avatars/'.$collection[1]->race.'_'.$collection[1]->class.'_'.$collection[1]->gender.'.bmp') }}" alt="logo"
                    class="border w-25 h-auto img-fluid rounded-circle">
                <p class="m-0">{{ $collection[1]->name }}</p>     
                <p>{{ $collection[1]->xp }} XP</p> 
            </div>
        </div>
    @endif
    @if($collection->count() >= 1)
        <div class="first-place">
            <img src="{{ asset('assets/gold.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium" data-id="/user/{{ $collection[0]->username }}">     
                <img src="{{ asset('assets/avatars/'.$collection[0]->race.'_'.$collection[0]->class.'_'.$collection[0]->gender.'.bmp') }}" alt="logo"
                    class="border w-25 h-auto img-fluid rounded-circle">
                <p class="m-0">{{ $collection[0]->name }}</p>     
                <p>{{ $collection[0]->xp }} XP</p> 
            </div>
        </div>
    @endif
    @if($collection->count() >= 3)
        <div class="third-place">
            <img src="{{ asset('assets/bronze.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium" data-id="/user/{{ $collection[2]->username }}">     
                <img src="{{ asset('assets/avatars/'.$collection[2]->race.'_'.$collection[2]->class.'_'.$collection[2]->gender.'.bmp') }}" alt="logo"
                    class="border w-25 h-auto img-fluid rounded-circle">
                <p class="m-0">{{ $collection[2]->name }}</p>     
                <p>{{ $collection[2]->xp }} XP</p> 
            </div>
        </div>
    @endif
</div>

@if($collection->count() > 3)
    <div class="d-flex justify-content-center mb-3 mr-3">
        <div class="leaderboard_search searchbar">
            <input class="search_input search_input_fixed" onkeyup="{{ $function }}()" type="text" placeholder="Search...">
            <div class="search_icon"><i class="fas fa-search"></i></div>
        </div>
    </div>

    <ol start="4" class="list pl-0 shadow-lg">
        @each('partials.leaderboardElement', $collection->slice(3,5), 'user')
    </ol>
@endif