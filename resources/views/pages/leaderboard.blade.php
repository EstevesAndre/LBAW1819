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
                    @if($global->count() === 0)
                        <p class="text-center py-2 bg-white">There are no users</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $global])
                    @endif
                </div>

                <div class="tab-pane fade" id="clan" role="tabpanel" aria-labelledby="clan-tab">
                    @if($clanMembers === null)
                        <p class="text-center py-2 bg-white">Join a clan or create one</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $clanMembers])
                    @endif
                </div>

                <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                    @if(count($friends) === 0)
                        <p class="text-center py-2 bg-white">{{ Auth::user()->name }}, you have no friends, add a friend</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $friends])
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => $friends])
</div>

@endsection