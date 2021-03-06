@extends('layouts.noFooter')

@section('pageTitle', 'Chat')

@section('content')
<br />
<div class="has-chat container mt-3 pt-3 height-94">
    <div class="row standard-text border rounded h-100">
        <div class="left-desktop col-sm-4 bg-light h-100 pt-4">
            <div class="h-100 scroolable">
                <div class="p-0 d-flex align-items-center">
                    <input type="text" class="border w-100 rounded no-outline search-box" placeholder="Search a friend ..." required>
                    <i class="left fas fa-search"></i>
                </div>
                <div class="list-group text-left" id="list-tab" role="tablist">
                    @if(!$friends->isEmpty())
                    <a class="friend-list list-group-item list-group-item-action active" data-id="{{ $friends[0]->id }}">
                        <img src="{{ asset('assets/avatars/'.$friends[0]->race.'_'.$friends[0]->class.'_'.$friends[0]->gender.'.bmp') }}"
                         alt="logo" width="25" class="border img-fluid rounded-circle">
                    {{ $friends[0]->name }}
                    </a>
                    @each('partials.chatFriend', $friends->slice(1,10), 'user') 
                    @else
                        <div class="text-center py-5">You have 0 friends!</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 pt-4 h-100">
            <div class="just-mobile border rounded p-0 d-flex align-items-center">
                <input type="text" class="m-2 border w-90 no-outline search-box" placeholder="Search a friend here..." required>
                <i class="left fas fa-search"></i>
            </div>
            @if(!$friends->isEmpty())
            <div class="friend-chat border rounded hgt" data-id="{{ $friends[0]->id }}">
                <div class="h-100 parent">
                    <div class="fixed-at-top p-3 w-100 border rounded text-left tab-content chat-content" id="nav-tabContent">
                        <div class="tab-pane fade show active">
                            <img src="{{ asset('assets/avatars/'.$friends[0]->race.'_'.$friends[0]->class.'_'.$friends[0]->gender.'.bmp') }}" alt="logo" width="25" class="border img-fluid rounded-circle">
                            <a href="/user/{{ $friends[0]->username }}">{{ $friends[0]->name }}</a>
                            <!-- Button trigger modal -->
                            <button type="button" class="border-0 btn btn-default rounded-circle chat-help" data-toggle="tooltip" data-placement="auto" data-html="true">
                                <i class="fas fa-question-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div id="chatScroll" class="w-100 fixed-at-top pt-4 chat-margins scroolable">
                            @each('partials.message', $messages, 'message')
                    </div>
                    <div class="fixed-at-bottom bg-white border-top w-100 send-message p-0 d-flex align-items-center" id="message-send">
                        <input type="text" class="m-2 border w-89 no-outline" id="message-box" placeholder="Write a message here..." required>
                        <button type="submit" class="btn btn-primary float-right mr-2" id="send-button"><i class="fas fa-envelope"></i></button>
                    </div>
                </div>
            </div>
            @else
            <h2 class="text-center py-5">Sorry bro...</h2>
            @endif 
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="chat_helpModal" tabindex="-1" role="dialog" aria-labelledby="chat_helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chat_helpModalLabel">Chat Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            This is the chat.
            </div>
        </div>
    </div>
</div>
@endsection