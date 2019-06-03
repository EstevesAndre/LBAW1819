@extends('layouts.app')

@section('content')

<br />
<div class="mt-5 row text-center fullscreen standard-text">
    
    <div class="col-sm-12 col-md-8 col-lg-9 my-3 activity">
        <h1 class="text-left"><b>Friend Requests</b></h1>
        <button type="button" class="border-0 btn btn-default btn-circle" data-toggle="modal" data-target="#friendrequests_helpModal">
                <i class="fas fa-question-circle"></i>
        </button>
        <div class="clan-page-info">
            <ul class="mt-4 nav nav-tabs justify-content-center" id="clan-tabs" role="tablist">
                <li class="nav-item">
                    @if($sent->count() !== 0)
                        <a class="tab-title nav-link active text-white bg-danger" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="true">Requests Sent ({{ $sent->count() }})</a>
                    @else
                        <a class="tab-title nav-link active" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="true">Requests Sent</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if($received->count() !== 0)
                        <a class="tab-title nav-link text-white bg-danger" id="received-tab" data-toggle="tab" href="#received" role="tab" aria-controls="received" aria-selected="false">Requests Received ({{ $received->count() }})</a>
                    @else
                        <a class="tab-title nav-link" id="received-tab" data-toggle="tab" href="#received" role="tab" aria-controls="received" aria-selected="false">Requests Received</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if($rejected->count() !== 0)
                        <a class="tab-title nav-link text-white bg-danger" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">Requests Rejected ({{ $rejected->count() }})</a>
                    @else
                        <a class="tab-title nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">Requests Rejected</a>
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
                        <div class="d-flex justify-content-center mb-3 mr-3">
                            <div class="searchbar">
                                <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                    
                        <ul class="pl-0 shadow-lg py-3 mt-3 users-list">
                            @each('partials.requestSent', $sent, 'request')
                            <li class="p-2 ml-3"> <!-- TO BE DELETED-->
                                <div class="d-flex align-items-center row">
                                    <div class="pl-3 col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="User">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Arthur Morgan</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-danger btn-request" data-toggle="modal" data-target="#removeFriendModal">
                                            <i class="fas fa-times"></i> <span>Cancel Request</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
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
                        <div class="d-flex justify-content-center mb-3 mr-3">
                            <div class="searchbar">
                                <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>

                        <ul class="pl-0 shadow-lg py-3 mt-3 users-list">
                            @each('partials.requestReceived', $received, 'request')
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="User">
                                    </div>
                                    <div class="col-5 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Margarida</a></div>
                                    <div class="col-4 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-success btn-request">
                                            <i class="fas fa-check"></i> <span>Accept</span>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-request">
                                            <i class="fas fa-times"></i> <span>Decline</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            @if($received->count() > 5)
                                <p class="text-center mt-3 mb-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
                        </ul>
                    @else
                        <p class="text-center mt-3 mb-0 standard-text">There are no received requests!</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                    @if($rejected->count() !== 0)
                        <div class="d-flex justify-content-center mb-3 mr-3">
                            <div class="searchbar">
                                <input class="search_input search_input_fixed" type="text" name="" placeholder="Search...">
                                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                        <ul class="pl-0 shadow-lg py-3 mt-3 users-list">
                            @each('partials.requestRejected', $rejected, 'request')
                            <li class="p-2 ml-3">
                                <div class="d-flex align-items-center row">
                                    <div class="col-2 col-sm-2 col-md-1 friend-img">
                                        <img width="40" class="border bg-warning img-fluid rounded-circle border"
                                            src="../assets/logo.png" alt="User">
                                    </div>
                                    <div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../pages/profile.html">Luís Ricardo</a></div>
                                    <div class="col-3 col-sm-4 col-md-4 px-0 text-right">
                                        <button type="button" class="btn btn-primary btn-request">
                                            <i class="fas fa-redo"></i> <span>Send another Request</span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            @if($rejected->count() > 5)
                                <p class="text-center mt-3 mb-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                            @endif
                        </ul>
                    @else
                        <p class="text-center mt-3 mb-0 standard-text">There are no rejeceted requests!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.chatSideBar', ['friends' => Auth::user()->friends() ])
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