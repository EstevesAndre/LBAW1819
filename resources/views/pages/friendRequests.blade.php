@extends('layouts.app')

@section('pageTitle', 'Requests')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen standard-text">
    
    <div class="col-sm-12 col-md-8 col-lg-9 my-3 activity">
        <h1 class="text-left"><b>Friend Requests</b></h1>
        <button type="button" class="border-0 btn btn-default rounded-circle" data-toggle="modal" data-target="#friendrequests_helpModal">
                <i class="fas fa-question-circle"></i>
        </button>
        <div class="clan-page-info">
            <ul class="mt-4 nav nav-tabs justify-content-center" id="clan-tabs" role="tablist">
                <li class="nav-item">
                    @if($sent->count() !== 0)
                        <a class="tab-title nav-link active text-white bg-danger" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="true">Requests Sent (<span>{{ $sent->count() }}</span>)</a>
                    @else
                        <a class="tab-title nav-link active" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="true">Requests Sent</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if($received->count() !== 0)
                        <a class="tab-title nav-link text-white bg-danger" id="received-tab" data-toggle="tab" href="#received" role="tab" aria-controls="received" aria-selected="false">Requests Received (<span>{{ $received->count() }}</span>)</a>
                    @else
                        <a class="tab-title nav-link" id="received-tab" data-toggle="tab" href="#received" role="tab" aria-controls="received" aria-selected="false">Requests Received</a>
                    @endif
                </li>
                <li class="nav-item">
                        @if($clans->count() !== 0)
                            <a class="tab-title nav-link text-white bg-danger" id="clan-received-tab" data-toggle="tab" href="#clan-received" role="tab" aria-controls="clan-received" aria-selected="false">Clan Requests (<span>{{ $clans->count() }}</span>)</a>
                        @else
                            <a class="tab-title nav-link" id="clan-received-tab" data-toggle="tab" href="#clan-received" role="tab" aria-controls="clan-received" aria-selected="false">Clan Requests</a>
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
                <div class="text-left tab-pane fade active show" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                    @if($sent->count() !== 0)                   
                        <ul class="pl-0 shadow-lg my-3 mt-3 users-list sent-r">
                            @each('partials.requestSent', $sent, 'request')
                            @if($sent->count() > 5)
                                <p class="text-center mt-3 mb-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
                        </ul>
                    @else
                        <p class="text-center mt-3 mb-0 standard-text">There are no sent requests!</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="received" role="tabpanel" aria-labelledby="received-tab">
                    @if($received->count() !== 0)
                        <ul class="pl-0 shadow-lg my-3 users-list received-r">
                            @each('partials.requestReceived', $received, 'request')
                            @if($received->count() > 5)
                                <p class="text-center mt-3 mb-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
                        </ul>
                    @else
                        <p class="text-center mt-3 mb-0 standard-text">There are no received requests!</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="clan-received" role="tabpanel" aria-labelledby="clan-received-tab">
                    @if($clans->count() !== 0)
                        <ul class="pl-0 shadow-lg my-3 users-list clan-received-r">
                            @each('partials.clanRequestReceived', $clans, 'clan')
                            @if($clans->count() > 5)
                                <p class="text-center mt-3 mb-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
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
<!-- Modal -->
<div class="modal fade" id="friendrequests_helpModal" tabindex="-1" role="dialog" aria-labelledby="friendrequests_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="friendrequests_helpModalLabel">Friend Requests Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the friend requests pages.
            </div>
        </div>
    </div>
</div>
@endsection