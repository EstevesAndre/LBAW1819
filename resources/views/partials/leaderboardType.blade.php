<div class="leaders mb-5 row mx-1">
    @if($collection->count() >= 2)
        <div class="second-place">
            <img src="{{ asset('assets/silver.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">     
                <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                <p class="m-0">{{ $collection[1]->name }}</p>     
                <p>{{ $collection[1]->xp }} XP</p> 
            </div>
        </div>
    @endif
    @if($collection->count() >= 1)
        <div class="first-place">
            <img src="{{ asset('assets/gold.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">     
                <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                <p class="m-0">{{ $collection[0]->name }}</p>     
                <p>{{ $collection[0]->xp }} XP</p> 
            </div>
        </div>
    @endif
    @if($collection->count() >= 3)
        <div class="third-place">
            <img src="{{ asset('assets/bronze.png') }}" alt="logo" class="img-fluid rounded">
            <div class="podium">     
                <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                <p class="m-0">{{ $collection[2]->name }}</p>     
                <p>{{ $collection[2]->xp }} XP</p> 
            </div>
        </div>
    @endif
</div>

@if($collection->count() > 3)
    <div class="d-flex justify-content-center mb-3 mr-3">
        <div class="searchbar">
            <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
            <a href="" class="search_icon"><i class="fas fa-search"></i></a>
        </div>
    </div>

    <ol start="4" class="pl-0 shadow-lg">
        @each('partials.leaderboardElement', $collection->slice(3,5), 'user')
        @if($collection->count() > 3+5)
            <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
        @endif
    </ol>
@endif