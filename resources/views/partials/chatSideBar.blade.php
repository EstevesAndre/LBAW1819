<div class="col-sm-12 col-md-4 col-lg-3 bg-light side-bar side">
    @if($friends->count() == 0) 
        <p class="text-center"><small>Add a friend to chat with him!</small></p>
    @else
        <div class="d-flex justify-content-center">
            <div class="searchbar searchbar-fixed">
                <input class="search_input search_fixed" type="text" name="" placeholder="Search...">
                <a href="" class="search_icon"><i class="fas fa-search"></i></a>
            </div>
        </div>
        <div class="height-45 scroolable">
            <div class="list-group text-left" id="list-tab" role="tablist">
                <a class="friend-list list-group-item list-group-item-action active" id="{{ $friends[0]->id }}" data-toggle="list" href="#list-{{ $friends[0]->id }}" aria-controls="{{ $friends[0]->id }}">
                    <img src="{{ asset('assets/avatars/'.$friends[0]->race.'_'.$friends[0]->class.'_'.$friends[0]->gender.'.bmp') }}" alt="logo" width="25" class="mr-2 border bg-warning img-fluid rounded-circle">
                {{ $friends[0]->name }}
                </a>
                @each('partials.chatFriend', $friends->slice(1)->take(14), 'user')
                @if(count($friends) > 15)
                    <p class="text-center list-group-item p-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                @endif
            </div>
        </div>
    @endif
    <div class="border-left height-45 friend-chat">
        <div class="py-3 px-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-1" role="tabpanel" aria-labelledby="list-1-list">
                <img src="{{ asset('assets/avatars/'.$friends[0]->race.'_'.$friends[0]->class.'_'.$friends[0]->gender.'.bmp') }}" alt="logo" width="25"
                    class="mr-2 border bg-warning img-fluid rounded-circle">
                <a href="/user/{{ $friends[0]->username }}">{{ $friends[0]->name }}</a>
            </div>
        </div>
        <div id="chatScroll" class="h-80 scroolable">
                @each('partials.message', Auth::user()->friendChatMessages($friends[0]->id), 'message')
        </div>
        <div class="border-top border-left w-100 bottom-contained send-message p-0 d-flex align-items-center">
            <input type="text" class="m-2 border w-75 no-outline" id="message-box" placeholder="Write a message here..."
                required>
            <button type="submit" class="btn btn-primary m-1 float-right" id="send-button">&#9993;</button>
        </div>
    </div>
</div>