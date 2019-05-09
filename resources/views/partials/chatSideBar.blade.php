<div class="col-sm-12 col-md-4 col-lg-3 bg-light side-bar side">
    @if(count($friends) == 0) 
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
                <a class="friend-list list-group-item list-group-item-action" id="list-{{ $friends[0]->id }}-list" data-toggle="list" href="#list-{{ $friends[0]->id }}" role="tab" aria-controls="{{ $friends[0]->id }}">
                    <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25" class="border bg-warning img-fluid rounded-circle">
                    {{ $friends[0]->name }}
                </a>
                @each('partials.chatFriend', $friends->slice(1)->take(14), 'user')
                @if(count($friends) > 15)
                    <p class="text-center list-group-item p-0 standard-text"><span>See more </span><i class="fas fa-caret-down"></i></p>
                @endif
            </div>
        </div>
    @endif
    <div class="border-left height-45">
        <div class="py-3 px-3 border rounded text-left tab-content chat-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-{{ $friends[0]->id }}" role="tabpanel" aria-labelledby="list-{{ $friends[0]->id }}-list">
                <img src="{{ asset('assets/logo.png') }}" alt="logo" width="25" class="border bg-warning img-fluid rounded-circle">
                <a href="/user/{{ $friends[0]->username }}">{{ $friends[0]->name }}</a>
            </div>
            @each('partials.chatFriendSelected', $friends->slice(1)->take(14), 'user')
        </div>
        <div class="border-top border-left w-100 bottom-contained send-message p-0 d-flex align-items-center">
            <input type="text" class="m-2 border w-75 no-outline" id="message-box" placeholder="Write a message here..."
                required>
            <button type="submit" class="btn btn-primary m-1 float-right" id="send-button">&#9993;</button>
        </div>
    </div>
</div>