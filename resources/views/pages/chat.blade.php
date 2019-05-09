@extends('layouts.app')

@section('content')
<br />
<br />
<div class="container justify-content-center height-90 pt-3">
    <div class="row standard-text border rounded h-100">
        <div class="left-desktop col-sm-4 bg-light p-4 h-100">
            <div class="border rounded p-0 d-flex align-items-center">
                <input type="text" class="m-2 border w-90 no-outline search-box" placeholder="Search a friend here..." required>
                <i class="left fas fa-search"></i>
            </div>
            <div class="height-90 scroolable">
                <div class="list-group text-left" id="list-tab" role="tablist">
                <a class="friend-list list-group-item list-group-item-action active" data-id="{{ $friends[0]->id }}">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25" class="border bg-warning img-fluid rounded-circle">
                {{ $friends[0]->name }}
                </a>
                @each('partials.chatFriend', array_slice($friends,1,10), 'user')    
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 py-4 h-100">
            <div class="just-mobile border rounded p-0 d-flex align-items-center">
                <input type="text" class="m-2 border w-90 no-outline search-box" placeholder="Search a friend here..." required>
                <i class="left fas fa-search"></i>
            </div>
            <div class="friend-chat border rounded hgt" id="{{ $friends[0]->id }}">
                <div class="p-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-1" role="tabpanel" aria-labelledby="list-1-list">
                        <img src="../assets/logo.png" alt="logo" width="25"
                            class="border bg-warning img-fluid rounded-circle">
                        <a href="/user/{{ $friends[0]->username }}">{{ $friends[0]->name }}</a>
                    </div>
                </div>
                <div class="height-85 mobile-height" id="chat-body">
                    <div class="height-90 scroolable m-3">
                        @each('partials.message', $messages, 'message')
                    </div>
                </div>
                <div class="border-top send-message d-flex align-items-center" id="message-send">
                    <input type="text" class="m-2 w-80 border no-outline" id="message-box" placeholder="Write a message here..." required>
                    <button class="btn btn-link float-right"><i class="fas fa-images icon"></i></button>
                    <button type="submit" class="btn btn-link no-hover icon float-right" >Send <i class="fas fa-angle-right"></i></button>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection