@extends('layouts.app')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen-3-4 m-0 standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">

        <div class="clan-page-info">
            <ul class="d-flex justify-content-center mt-3 nav nav-tabs" id="clan-tabs" role="tablist">
                <li class="nav-item">
                    <a class="tab-title nav-link active" id="global-tab" data-toggle="tab" href="#global" role="tab"
                        aria-controls="forum" aria-selected="true">Global</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="clan-tab" data-toggle="tab" href="#clan" role="tab"
                        aria-controls="members" aria-selected="false">Clan</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="friends-tab" data-toggle="tab" href="#friends" role="tab"
                        aria-controls="leaderboard" aria-selected="false">Friends</a>
                </li>
            </ul>

            <div class="mt-4 tab-content" id="leaderboard-content">
                <div class="text-left tab-pane fade border-0 active show" id="global" role="tabpanel" aria-labelledby="global-tab">
                    <div class="leaders mb-5 row mx-1">
                        @if($global->count() >= 2)
                            <div class="second-place">
                                <img src="{{ asset('assets/silver.png') }}" alt="logo" class="img-fluid rounded">
                                <div class="podium">     
                                    <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                                    <p class="m-0">{{ $global[1]->name }}</p>     
                                    <p>{{ $global[1]->xp }} XP</p> 
                                </div>
                            </div>
                        @endif
                        @if($global->count() >= 1)
                            <div class="first-place">
                                <img src="{{ asset('assets/gold.png') }}" alt="logo" class="img-fluid rounded">
                                <div class="podium">     
                                    <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                                    <p class="m-0">{{ $global[0]->name }}</p>     
                                    <p>{{ $global[0]->xp }} XP</p> 
                                </div>
                            </div>
                        @endif
                        @if($global->count() >= 3)
                            <div class="third-place">
                                <img src="{{ asset('assets/bronze.png') }}" alt="logo" class="img-fluid rounded">
                                <div class="podium">     
                                    <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                                    <p class="m-0">{{ $global[2]->name }}</p>     
                                    <p>{{ $global[2]->xp }} XP</p> 
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($global->count() > 3)
                        <div class="d-flex justify-content-center mb-3 mr-3">
                            <div class="searchbar">
                                <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>

                        <ol start="4" class="pl-0 shadow-lg">
                            @each('partials.leaderboardElement', $global->slice(3,5), 'user')
                            @if($global->count() > 3+5)
                                <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
                        </ol>
                    @endif
                </div>

                <div class="tab-pane fade" id="clan" role="tabpanel" aria-labelledby="clan-tab">
                    <div class="leaders mb-5 row mx-1">
                        <div class="second-place">
                            <img src="../assets/silver.png" alt="logo" class="img-fluid rounded">
                            <div class="podium">
                                <img src="../assets/logo.png" alt="logo"
                                    class="border w-25 h-auto img-fluid rounded-circle">
                                <p class="m-0">André Esteves</p>
                                <p>22345678 XP</p>
                            </div>
                        </div>

                        <div class="first-place">
                            <img src="../assets/gold.png" alt="logo" class="img-fluid rounded">
                            <div class="podium">
                                <img src="../assets/logo.png" alt="logo"
                                    class="border w-25 h-auto img-fluid rounded-circle">
                                <p class="m-0">André Esteves</p>
                                <p>123456789 XP</p>
                            </div>
                        </div>

                        <div class="third-place">
                            <img src="../assets/bronze.png" alt="logo" class="img-fluid rounded">
                            <div class="podium">
                                <img src="../assets/logo.png" alt="logo"
                                    class="border w-25 h-auto img-fluid rounded-circle">
                                <p class="m-0">André Esteves</p>
                                <p>12345678 XP</p>
                            </div>
                        </div>
                        @if($clanMembers == null)
                            JOIN A CLAN
                        @endif
                        @if($global->count() >= 2)
                            <div class="second-place">
                                <img src="{{ asset('assets/silver.png') }}" alt="logo" class="img-fluid rounded">
                                <div class="podium">     
                                    <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                                    <p class="m-0">{{ $global[1]->name }}</p>     
                                    <p>{{ $global[1]->xp }} XP</p> 
                                </div>
                            </div>
                        @endif
                        @if($global->count() >= 1)
                            <div class="first-place">
                                <img src="{{ asset('assets/gold.png') }}" alt="logo" class="img-fluid rounded">
                                <div class="podium">     
                                    <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                                    <p class="m-0">{{ $global[0]->name }}</p>     
                                    <p>{{ $global[0]->xp }} XP</p> 
                                </div>
                            </div>
                        @endif
                        @if($global->count() >= 3)
                            <div class="third-place">
                                <img src="{{ asset('assets/bronze.png') }}" alt="logo" class="img-fluid rounded">
                                <div class="podium">     
                                    <img src="{{ asset('assets/logo.png') }}" alt="logo" class="border w-25 h-auto img-fluid rounded-circle">     
                                    <p class="m-0">{{ $global[2]->name }}</p>     
                                    <p>{{ $global[2]->xp }} XP</p> 
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                            <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                        </div>
                    </div>

                    <ol start="4" class="pl-0 shadow-lg">
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-light img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Luís Silva</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">2352336 XP</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-success img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">André Esteves</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">52336 XP</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-warning img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Francisco Filipe</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">2336 XP</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-danger img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">João Miguel</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">336 XP</div>
                                </div>
                            </li>
                        </button>
                        <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
                    </ol>
                </div>

                <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                    <div class="leaders mb-5 row mx-1">
                        <div class="second-place">
                            <img src="../assets/silver.png" alt="logo" class="img-fluid rounded">
                            <div class="podium">
                                <img src="../assets/logo.png" alt="logo"
                                    class="border w-25 h-auto img-fluid rounded-circle">
                                <p class="m-0">André Esteves</p>
                                <p>22345678 XP</p>
                            </div>
                        </div>

                        <div class="first-place">
                            <img src="../assets/gold.png" alt="logo" class="img-fluid rounded">
                            <div class="podium">
                                <img src="../assets/logo.png" alt="logo"
                                    class="border w-25 h-auto img-fluid rounded-circle">
                                <p class="m-0">André Esteves</p>
                                <p>123456789 XP</p>
                            </div>
                        </div>

                        <div class="third-place">
                            <img src="../assets/bronze.png" alt="logo" class="img-fluid rounded">
                            <div class="podium">
                                <img src="../assets/logo.png" alt="logo"
                                    class="border w-25 h-auto img-fluid rounded-circle">
                                <p class="m-0">André Esteves</p>
                                <p>12345678 XP</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mb-3 mr-3">
                        <div class="searchbar">
                            <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                            <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                        </div>
                    </div>

                    <ol start="4" class="pl-0 shadow-lg">
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-light img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Luís Silva</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">2352336 XP</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-success img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">André Esteves</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">52336 XP</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-warning img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">Francisco Filipe</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">2336 XP</div>
                                </div>
                            </li>
                        </button>
                        <button type="button" class="text-left list-group-item border-0 list-group-item-action">
                            <li class="ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-1 friend-img">
                                        <img src="../assets/logo.png" alt="logo"
                                            class="border bg-danger img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5 col-sm-6 pr-1">João Miguel</div>
                                    <div class="col-5 col-sm-5 pl-1 text-right">336 XP</div>
                                </div>
                            </li>
                        </button>
                        <p class="text-center py-2 bg-white"><span>See more </span><i class="fas fa-caret-down"></i></p>
                    </ol>
                </div>
            </div>
        </div>
    </div>

{{-- 
    <div class="col-sm-12 col-md-4 col-lg-3 bg-light side-bar side">
        <div class="d-flex justify-content-center">
            <div class="searchbar searchbar-fixed">
                <input class="search_input search_fixed" type="text" name="" placeholder="Search...">
                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
            </div>
        </div>
        <div class="height-45 scroolable">
            <div class="list-group text-left" id="list-tab" role="tablist">
                <a class="friend-list list-group-item list-group-item-action active" id="list-1-list"
                    data-toggle="list" href="#list-1" role="tab" aria-controls="1">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-2-list" data-toggle="list"
                    href="#list-2" role="tab" aria-controls="2">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-3-list" data-toggle="list"
                    href="#list-3" role="tab" aria-controls="3">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-4-list" data-toggle="list"
                    href="#list-4" role="tab" aria-controls="3">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-5-list" data-toggle="list"
                    href="#list-5" role="tab" aria-controls="5">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-6-list" data-toggle="list"
                    href="#list-6" role="tab" aria-controls="6">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-7-list" data-toggle="list"
                    href="#list-7" role="tab" aria-controls="7">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-8-list" data-toggle="list"
                    href="#list-8" role="tab" aria-controls="8">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-9-list" data-toggle="list"
                    href="#list-9" role="tab" aria-controls="9">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    André Esteves
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-10-list" data-toggle="list"
                    href="#list-10" role="tab" aria-controls="10">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Luís Diogo Silva
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-11-list" data-toggle="list"
                    href="#list-11" role="tab" aria-controls="11">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    Francisco Filipe
                </a>
                <a class="friend-list list-group-item list-group-item-action" id="list-12-list" data-toggle="list"
                    href="#list-12" role="tab" aria-controls="12">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    João Miguel
                </a>
                <p class="text-center list-group-item p-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
            </div>
        </div>
        <div class="border-left height-45">
            <div class="p-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-1" role="tabpanel" aria-labelledby="list-1-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-2" role="tabpanel" aria-labelledby="list-2-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-3" role="tabpanel" aria-labelledby="list-3-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-4" role="tabpanel" aria-labelledby="list-4-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">João Miguel</a>
                </div>
                <div class="tab-pane fade" id="list-5" role="tabpanel" aria-labelledby="list-5-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-6" role="tabpanel" aria-labelledby="list-6-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-7" role="tabpanel" aria-labelledby="list-7-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-8" role="tabpanel" aria-labelledby="list-8-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">João Miguel</a>
                </div>
                <div class="tab-pane fade" id="list-9" role="tabpanel" aria-labelledby="list-9-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">André Esteves</a>
                </div>
                <div class="tab-pane fade" id="list-10" role="tabpanel" aria-labelledby="list-19-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Luís Diogo Silva</a>
                </div>
                <div class="tab-pane fade" id="list-11" role="tabpanel" aria-labelledby="list-11-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">Francisco Filipe</a>
                </div>
                <div class="tab-pane fade" id="list-12" role="tabpanel" aria-labelledby="list-12-list">
                    <img src="../assets/logo.png" alt="logo" width="25"
                        class="border bg-warning img-fluid rounded-circle">
                    <a href="../pages/profile.html">João Miguel</a>
                </div>
            </div>
            <div class="border-top border-left w-100 bottom-contained send-message p-0 d-flex align-items-center">
                <input type="text" class="m-2 border w-75 no-outline" id="message-box" placeholder="Write a message here..."
                    required>
                <button type="submit" class="btn btn-primary m-1 float-right" id="send-button">&#9993;</button>
            </div>
        </div>
    </div>
     --}}
</div>

@endsection