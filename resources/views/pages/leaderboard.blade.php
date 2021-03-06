@extends('layouts.app')

@section('pageTitle', 'Leaderboards')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen-3-4 m-0 standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 mb-4 activity">

        <div class="clan-page-info">
            <ul class="d-flex justify-content-center mt-3 nav nav-tabs" id="clan-tabs">
                <li class="nav-item">
                    <a class="tab-title nav-link active" id="global-tab" data-toggle="tab" href="#global">Global</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="clan-tab" data-toggle="tab" href="#clan">Clans</a>
                </li>
                <li class="nav-item">
                    <a class="tab-title nav-link" id="friends-tab" data-toggle="tab" href="#friends">Friends</a>
                </li>
            </ul>
            <button type="button" class="float-right border-0 btn btn-default btn-circle leader-boards-help" data-toggle="tooltip" data-placement="auto" data-html="true">
                    <i class="fas fa-question-circle"></i>
            </button>

            <div class="mt-4 tab-content" id="leaderboard-content">
                <div class="to_link text-left tab-pane fade border-0 active show" id="global" role="tabpanel" aria-labelledby="global-tab">
                    @if($global->count() === 0)
                        <p class="text-center py-2 bg-white">There are no users</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $global, 'function' => 'updateSearchGlobal'])
                    @endif
                </div>

                <div class="tab-pane fade" id="clan" role="tabpanel" aria-labelledby="clan-tab">
                    @if($clans === null)
                        <p class="text-center py-2 bg-white">Join a clan or create one</p>
                    @else
                        @include('partials.leaderboardClanType', [ 'clan' => $clans, 'function' => 'updateSearchClan'])
                    @endif
                </div>

                <div class="to_link tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                    @if($friends->count() === 0)
                        <p class="text-center py-2 bg-white">{{ Auth::user()->name }}, you have no friends, add a friend</p>
                    @else
                        @include('partials.leaderboardType', [ 'collection' => $friends, 'function' => 'updateSearchFriends'])
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => $friends])
</div>
<!-- Modal -->
<div class="modal fade" id="leaderboard_helpModal" tabindex="-1" role="dialog" aria-labelledby="leaderboard_helpModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaderboard_helpModalLabel">Leaderboard Help</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                This is the leaderboard page.
                </div>
            </div>
        </div>
    </div>
@endsection