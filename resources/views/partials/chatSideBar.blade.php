<div class="col-sm-12 col-md-4 col-lg-3 bg-light side-bar side">
    @if($friends->count() !== 0) 
        <div class="height-45 scroolable">
            <div class="chat-side-bar list-group text-left" id="list-tab">
                <a class="friend-list list-group-item list-group-item-action active" data-id="{{ $friends[0]->id }}">
                    <img src="{{ asset('assets/avatars/'.$friends[0]->race.'_'.$friends[0]->class.'_'.$friends[0]->gender.'.bmp') }}" alt="logo" width="25" class="mr-2 border bg-warning img-fluid rounded-circle">
                    {{ $friends[0]->name }}
                </a>
                @each('partials.chatFriend', $friends->slice(1)->take(14), 'user')
            </div>
        </div>
        <div class="border-left height-55 friend-chat" data-id="{{ $friends[0]->id }}">
            <div class="p-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
                <div class="tab-pane fade show active">
                    <img src="{{ asset('assets/avatars/'.$friends[0]->race.'_'.$friends[0]->class.'_'.$friends[0]->gender.'.bmp') }}" alt="logo" width="25"
                        class="mr-2 border img-fluid rounded-circle">
                    <a href="/user/{{ $friends[0]->username }}">{{ $friends[0]->name }}</a>
                </div>
            </div>
            <div id="chatScroll" class="h-80 scroolable">
                @each('partials.message', Auth::user()->friendChatMessages($friends[0]->id), 'message')
            </div>
            <div class="bg-white border-top border-left w-100 send-message p-0 d-flex align-items-center" id="message-send">
                <input type="text" class="m-2 border w-75 no-outline" id="message-box" placeholder="Write a message here..."
                    required>
                <button type="submit" class="btn btn-primary m-1 float-right rounded-circle" id="send-button">&#9993;</button>
            </div>
        </div>
    @endif
</div>