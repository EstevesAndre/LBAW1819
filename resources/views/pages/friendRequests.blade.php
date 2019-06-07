@extends('layouts.app')

@section('pageTitle', 'Requests')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen standard-text">
    <div class="col-sm-12 col-md-8 col-lg-9 my-3 activity">
        <h1 class="text-left"><b>Friend Requests</b>
            <button type="button" class="border-0 btn btn-default rounded-circle friend-requests-help" data-toggle="tooltip" data-placement="auto" data-html="true">
                    <i class="fas fa-question-circle"></i>
            </button>
        </h1>
        <div>
            <ul class="nav nav-pills nav-fill py-3 border-bottom">
                <li class="nav-item m-2">
                    @if($sent->count() !== 0)
                        <a class="tab-title nav-link active text-white bg-secondary" id="sent-tab" data-toggle="tab" href="#sent">Requests Sent (<span class="not-zero">{{ $sent->count() }}</span>)</a>
                    @else
                        <a class="tab-title nav-link text-white bg-secondary" id="sent-tab" data-toggle="tab" href="#sent">Requests Sent (0)</a>
                    @endif
                </li>
                <li class="nav-item m-2">
                        @if($received->count() !== 0)
                            <a class="tab-title nav-link text-white bg-secondary" id="received-tab" data-toggle="tab" href="#received">Requests Received (<span class="not-zero">{{ $received->count() }}</span>)</a>
                        @else
                            <a class="tab-title nav-link text-white bg-secondary" id="received-tab" data-toggle="tab" href="#received">Requests Received (0)</a>
                        @endif
                    </li>
                <li class="nav-item m-2">
                    @if($clans->count() !== 0)
                        <a class="tab-title nav-link text-white bg-secondary" id="clan-received-tab" data-toggle="tab" href="#clan-received">Clan Requests (<span class="not-zero">{{ $clans->count() }}</span>)</a>
                    @else
                        <a class="tab-title nav-link text-white bg-secondary" id="clan-received-tab" data-toggle="tab" href="#clan-received">Clan Requests (0)</a>
                    @endif
                </li>
            </ul>

            <div class="modal fade" id="removeFriendModal" tabindex="-1" role="dialog" aria-labelledby="removeFriendModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="removeFriendModalLabel">Cancel Friend Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure that you want to cancel?</p>
                            <div class="float-right">
                                <button type="button" class="btn btn-success">Yes</button>
                                <button type="button" class="btn btn-danger">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 tab-content" id="content">
                <div class="text-left tab-pane fade active show" id="sent">
                    @if($sent->count() !== 0)                   
                        <ul class="pl-0 shadow-lg py-2 mt-3 users-list sent-r">
                            @each('partials.requestSent', $sent, 'request')
                        </ul>
                    @else
                        <p class="text-center mt-3 mb-0 standard-text">There are no sent requests!</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="received">
                    @if($received->count() !== 0)
                        <ul class="pl-0 shadow-lg py-2 users-list received-r">
                            @each('partials.requestReceived', $received, 'request')
                        </ul>
                    @else
                        <p class="text-center mt-3 mb-0 standard-text">There are no received requests!</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="clan-received">
                    @if($clans->count() !== 0)
                        <ul class="pl-0 shadow-lg py-2 users-list clan-received-r">
                            @each('partials.clanRequestReceived', $clans, 'clan')
                        </ul>
                    @else
                        <p class="text-center mt-3 mb-0 standard-text">There are no clan requests!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => Auth::user()->friends()->get() ])
</div>
@endsection