function addEventListeners() {

    let deleteLike = document.querySelectorAll('li>a>i.fa-thumbs-up.active');
    [].forEach.call(deleteLike, function (like) {
        like.addEventListener('click', sendDeleteLikeRequest);
    });
    let addLike = document.querySelectorAll('li>a>i.fa-thumbs-up:not(.active)');
    [].forEach.call(addLike, function (like) {
        like.addEventListener('click', sendAddLikeRequest);
    });

    let friendList = document.querySelectorAll('#friends>ul>li>button, #members>ul>li>button, #leaderboard-content>div>ol>button, #leaderboard>ol>button');
    [].forEach.call(friendList, function (friend) {
        friend.addEventListener('click', function () {
            window.location.href = this.getAttribute('data-id');
        });
    });

    let addPost = document.querySelector('#postModal>div>div>div.modal-footer>button.create');
    if (addPost) addPost.addEventListener('click', sendAddPostRequest);

    let postModal = document.querySelectorAll('div.postModal>div>div>div.modal-body>div>button.btn-danger');
    [].forEach.call(postModal, function (delPost) {
        delPost.addEventListener('click', sendDeletePostRequest);
    });

    let deleteComment = document.querySelectorAll('.delete-comment>a>i');
    [].forEach.call(deleteComment, function (delCom) {
        delCom.addEventListener('click', sendDeleteCommentRequest);
    });

    let notifications = document.querySelector('#notifications > button');
    if (notifications) notifications.addEventListener('click', sendUserNotificationsRequest);

    let sendComment = document.querySelector('.search-comment > button');
    if (sendComment) sendComment.addEventListener('click', sendAddCommentRequest);

    let sendMessage = document.querySelector('#message-send :nth-child(3)');
    if (sendMessage) sendMessage.addEventListener('click', sendAddMessageRequest);

    let chatFriends = document.querySelectorAll('.friend-list');
    [].forEach.call(chatFriends, function (friend) {
        friend.addEventListener('click', updateChatRequest);
    });

    let scrool = document.getElementById('chatScroll');
    if(scrool) scrool.scrollTop = scrool.scrollHeight;
    
    let hasChat = document.querySelector('.has-chat');
    
    if(hasChat != null)
    {
      let auth_id = document.querySelector('.has-chat').id;
      let friend_id = document.querySelector('.friend-chat').id;

      Echo.private('chat' + auth_id) //TODO add receiver id to channel name
      .listen('MessageSent', (e) => {
        if(e.sender == friend_id){
          let message_area = document.querySelector('#chat-body');
          message_area.innerHTML += '<div class="my-3 outgoing_msg"><div class="sent_msg"><p>' + reply.messages[i].message_text +'</p><span class="text-right mt-0 pt-0 time_date">' + reply.messages[i].date.substring(0, 10) + '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + reply.messages[i].date.substring(11, 19) + '</span></div></div>';

        }
      });
    }

    let openbanModal = document.querySelectorAll('.ban_member');
    [].forEach.call(openbanModal, function (member) {
        member.addEventListener('click', setBanModalID);
    });

    let banMember = document.querySelectorAll('.ban_modal');
    [].forEach.call(banMember, function (blocked) {
        blocked.addEventListener('click', sendBanMemberRequest);
    });

    let unbanMember = document.querySelectorAll('.unban_member');
    [].forEach.call(unbanMember, function (blocked) {
        blocked.addEventListener('click', sendUnBanMemberRequest);
    });

    // let generateButton = document.querySelector('.');
    // if (generateButton) generateButton.addEventListener('click', setCharacterInfo);
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}

// Requests
function sendDeleteLikeRequest() {
    console.log("Like delete request");
    let post_id = this.closest('div.post').getAttribute('data-id');

    sendAjaxRequest('delete', '/api/like/' + post_id, null, deletedLikeHandler);

    event.preventDefault();
}

function sendAddLikeRequest(event) {
    console.log("Like add request");

    let post_id = this.closest('div.post').getAttribute('data-id');

    sendAjaxRequest('put', '/api/like/' + post_id, null, addedLikeHandler);

    event.preventDefault();
}

function sendAddPostRequest(e) {
    console.log("Post add request");

    let content = document.querySelector('#postModal>div>div>div.modal-body>div>div.form-group>textarea').value;
    if (content == '') return;

    let clanID = document.querySelector('#postModal>div>div>div.modal-body>input').value;

   sendAjaxRequest('put', '/api/post', { content: content, clanID : clanID}, addedPostHanlder);
}

function sendDeletePostRequest(e) {
    console.log("Post delete request");

    let post_id = this.closest('div.postModal').getAttribute('data-id');

    if (post_id == null)
        return;

    sendAjaxRequest('delete', '/api/post/' + post_id, null, deletedPostHandler);
}

function sendDeleteCommentRequest(e) {
    console.log("Comment delete request");

    let comment_id = this.closest('span.delete-comment').getAttribute('id');

    if (comment_id == null)
        return;

    sendAjaxRequest('delete', '/api/comment/' + comment_id, null, deletedCommentHandler);
}

function sendUserNotificationsRequest(e) {
    console.log("Get notifications request");
    sendAjaxRequest('post', '/api/notifications', null, userNotificationsHandler);
}

function sendAddCommentRequest(e) {
    e.preventDefault();
    console.log("Add comment request");

    let input = document.querySelector('.search-comment > input').value;
    let post_id = document.querySelector('.post').getAttribute('data-id');

    if (input != "")
        sendAjaxRequest('put', '/api/comment/' + post_id, { comment: input }, addedCommentHandler);
}

function sendAddMessageRequest(e) {
    e.preventDefault();
    console.log("Add message request");
    
    let message = document.querySelector('#message-send > input');
    let input = message.value;
    message.value = '';
    let friend_id = document.querySelector('.friend-chat').id;

    if (input != "")
        sendAjaxRequest('put', '/api/chat/' + friend_id, { message: input }, addedMessageHandler);
}

function updateChatRequest(e) {
    e.preventDefault();
    console.log("Update chat request");
    let friend_id = e.target.id;
    sendAjaxRequest('put', '/api/update_chat/' + friend_id, null, updatedChatHandler);
}

function setBanModalID(e) {
    e.preventDefault();

    let id = e.target.id;
    let modal = document.querySelector('.ban_modal');

    modal.setAttribute('id', id);
}

function sendBanMemberRequest(e) {
    e.preventDefault();

    let member_id = e.target.id;

    console.log(member_id);

    let motives = document.querySelectorAll('.form-check-input');
    var checkedMotives = [];

    for (let i = 0; i < motives.length; i++) {
        // And stick the checked ones onto an array...
        if (motives[i].checked) {
            checkedMotives.push(motives[i]);
        }
     }

   if(checkedMotives.length == 0){
       console.log(document.querySelector());
       return;
   }
    console.log(motives);    
    sendAjaxRequest('post', '/api/banMember/' + member_id, null, banMemberHandler);
}

function sendUnBanMemberRequest(e) {
    e.preventDefault();
    console.log("Unban Member");

    sendAjaxRequest('post', '/api/unbanMember/' + blocked_id, null, unbanMemberHandler);
}

// Handlers
function deletedLikeHandler() {

    let like = JSON.parse(this.responseText);
    console.log("Like deleted - status: " + this.status + ", [1-removed;2-error]: " + like.status);

    let thumbs_up = document.querySelector('div.post[data-id="' + like.post_id + '"]>div>div>ul.fst>li>a');
    thumbs_up.innerHTML = "<i class='fa fa-thumbs-up'></i>";

    let numLikes = document.querySelector('div.post[data-id="' + like.post_id + '"]>div>div>ul.fst>li+li>a>span');
    let value = numLikes.innerHTML;
    value--;
    numLikes.innerHTML = value;

    addEventListeners();
}

function addedLikeHandler() {
    console.log("Like add - status: " + this.status);

    let like = JSON.parse(this.responseText);

    let thumbs_up = document.querySelector('div.post[data-id="' + like.post_id + '"]>div>div>ul.fst>li>a');
    thumbs_up.innerHTML = "<i class='fa fa-thumbs-up active'></i>";
    let numLikes = document.querySelector('div.post[data-id="' + like.post_id + '"]>div>div>ul.fst>li+li>a>span');
    let value = numLikes.innerHTML;
    value++;
    numLikes.innerHTML = value;

    addEventListeners();
}

function addedPostHanlder() {
    console.log("Post add - status: " + this.status);

    let post = JSON.parse(this.responseText);

    window.location.href = 'post/' + post.id;
}

function deletedPostHandler() {
    console.log("Post deleted - status: " + this.status);

    if (this.status == 200) {
        let post = JSON.parse(this.responseText);

        let postHTML = document.querySelector('div.post[data-id="' + post.id + '"]');
        postHTML.innerHTML = '';
    }

    window.location.href = '../home';
}

function deletedCommentHandler() {
    console.log("Comment deleted - status: " + this.status);

    if (this.status == 200) {
        let comment = JSON.parse(this.responseText);

        let commentHTML = document.querySelector('div.comment[id="' + comment.id + '"]');
        commentHTML.innerHTML = '';
    }
}

function userNotificationsHandler() {
    let response = JSON.parse(this.responseText);
    let notificationsArea = document.querySelector('#notifications > .dropdown-menu');

    notificationsArea.innerHTML = "";

    for (let i = 0; i < response.comments.length; i++) {
        notificationsArea.innerHTML += '<a class="no-hover index-nav" href="/post/' + response.comments[i].postid + '#' + response.comments[i].commentid + '"> <button class="dropdown-item dropdown-navbar" type="button">' + response.comments[i].name + ' commented your post.</button> </a>';
    }

    for (let i = 0; i < response.likes.length; i++) {
        notificationsArea.innerHTML += '<a class="no-hover index-nav" href="/post/' + response.comments[i].postid + '"> <button class="dropdown-item dropdown-navbar" type="button">' + response.comments[i].name + ' liked your post.</button> </a>';
    }

    for (let i = 0; i < response.shares.length; i++) {
        notificationsArea.innerHTML += '<a class="no-hover index-nav" href="/post/' + response.comments[i].postid + '"> <button class="dropdown-item dropdown-navbar" type="button">' + response.comments[i].name + ' shared your post.</button> </a>';
    }
}

function addedCommentHandler() {
    
    let comment = JSON.parse(this.responseText);
    let comment_area = document.querySelector('.container.comments');
    let comment_img = document.querySelector('.container.comments img');
    let current_comms = comment_area.innerHTML;

    let path = comment_img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));
   
    comment_area.innerHTML = '<div class="d-flex align-items-center comment" id="' + comment.id + '"><span class="comment-avatar float-left mr-2"><a href="/user/' + comment.user_id + '"><img class="rounded-circle bg-warning" src="' + path_header + '/avatars/' + comment.race + '_' + comment.class + '_' + comment.gender + '.bmp" alt="Avatar"></a></span><div class=w-90 comment-data pl-1 pr-0"><p class="pt-3">' + comment.comment_text + '</p></div><span class="ml-2 delete-comment" id="' + comment.id + '"><a><i class="fas fa-times"></i></a></span></div>';
    comment_area.innerHTML  += current_comms;

    let deleteComment = document.querySelectorAll('.delete-comment>a>i');
    [].forEach.call(deleteComment, function (delCom) {
        delCom.addEventListener('click', sendDeleteCommentRequest);
    });
}

function addedMessageHandler() {
    
    let message = JSON.parse(this.responseText);
    let message_area = document.querySelector('#chatScroll');
    message_area.innerHTML += 
          '<div class="my-3 outgoing_msg">'
        +   '<div class="sent_msg w-50 mr-2">' 
        +       '<p>' + message.message_text +'</p>'
        +       '<span class="text-right mt-0 pt-0 time_date">' + message.date.substring(0, 10) 
        +           '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + message.date.substring(11, 19)
        +           '&nbsp&nbsp'
        +       '</span>'
        +   '</div>'
        + '</div>';
}

function updatedChatHandler(){
    
    let reply = JSON.parse(this.responseText);
    
    let friend_id = document.querySelector('.friend-chat');
    let friend_names = document.querySelector('.friend-chat a');
    let friend_img = document.querySelector('.friend-chat img');

    let path = friend_img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    friend_id.setAttribute('id', reply.friend_info[0].id);
    friend_names.setAttribute('href', '/user/' + reply.friend_info[0].username);
    friend_names.innerHTML = reply.friend_info[0].name;
    friend_img.setAttribute('src', path_header + '/avatars/' + reply.friend_info[0].race + "_" + reply.friend_info[0].class + '_' + reply.friend_info[0].gender + '.bmp');
    
    let message_area = document.querySelector('#chatScroll');
    message_area.innerHTML = "";  
    for(let i = 0; i < reply.messages.length;i++){
        message_area.innerHTML += 
          '<div class="my-3 outgoing_msg">'
        +   '<div class="sent_msg w-100 mx-2 align-items-right">'
        +       '<p class=" align-self-right text-right w-50">' + reply.messages[i].message_text +'</p>'
        +       '<span class="text-right mt-0 pt-0 time_date">' 
        +           reply.messages[i].date.substring(0, 10) 
        +           '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' 
        +           reply.messages[i].date.substring(11, 19) 
        +           '&nbsp&nbsp'
        +       '</span>'
        +   '</div>'
        + '</div>';
    }

}

addEventListeners();
// ---------------------------------------------------------------------------------------------------------------------//

let lastSearch = "";

function updateFriendList($userID) {
    let currentSearch = document.querySelector('#friends>div>.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getFriendsListSearch/' + $userID, { search: lastSearch }, updateFriendsListSearch);   
}

function updateFriendsListSearch() {
    let reply = JSON.parse(this.responseText);

    let list = document.querySelector('#friends ul.list');
    list.innerHTML = "";

    let img = document.querySelector('img.img-fluid');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    userListHandler(reply, list, path_header);
}
// ---------------------------------------------------------------------------------------------------------------------//
function getLeaderboardSearchInfo() 
{
    let currentSearch = document.querySelector('#leaderboard-content>.active .leaderboard_search>input').value;
    if(lastSearch == currentSearch)
        return false;

    lastSearch = currentSearch;
    return true;
}

function updateSearchGlobal() 
{
    if(getLeaderboardSearchInfo())
        sendAjaxRequest('post', '/api/getLeaderboardGlobalSearch/', { search: lastSearch }, updateLeaderboardSearch);   
}

function updateSearchClan() 
{
    if(getLeaderboardSearchInfo())
        sendAjaxRequest('post', '/api/getLeaderboardClanSearch/', { search: lastSearch }, updateLeaderboardSearch);   
}

function updateSearchFriends() 
{
    if(getLeaderboardSearchInfo())
        sendAjaxRequest('post', '/api/getLeaderboardFriendsSearch/', { search: lastSearch }, updateLeaderboardSearch);   
}

function updateLeaderboardSearch() {
    let reply = JSON.parse(this.responseText);

    let list = document.querySelector('#leaderboard-content>.active ol.list');

    list.innerHTML = "";

    let img = document.querySelector('#leaderboard-content>.active .second-place>.podium>img');

    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.users.forEach(function(element) {

        list.innerHTML +=
            '<button data-id="/user/' + element.username + '" type="button" class="text-left list-group-item border-0 list-group-item-action">' + 
                '<li class="ml-3">' + 
                    '<div class="d-flex align-items-center row">' + 
                        '<div class="col-2 col-sm-1 friend-img">' + 
                            '<img src="' + path_header + '/avatars/' + 
                                        element.race + '_' + element.class + '_' + element.gender + '.bmp"' + 'alt=logo' + 
                                ' class="border bg-light img-fluid rounded-circle">' + 
                        '</div>' +
                        '<div class="col-7 col-sm-6 text-left">' + element.name + '</div>' +
                        '<div class="col-3 col-sm-5 text-right">' + element.xp + '</div>' + 
                    '</div>' + 
                '</li>' + 
            '</button>';
      });
}
// ---------------------------------------------------------------------------------------------------------------------//

function clanMembersSearch($userID) 
{
    let currentSearch = document.querySelector('#members.active>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getClanSearch/' + $userID, { search: lastSearch }, updateClanMembersSearch);   
}

function updateClanMembersSearch() {
    let reply = JSON.parse(this.responseText);

    let list = document.querySelector('#members.active>ul');
    list.innerHTML = "";

    let img = document.querySelector('img.img-fluid');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    userListHandler(reply, list, path_header);
}


// ---------------------------------------------------------------------------------------------------------------------//

function clanLeaderboardSearch($userID) 
{
    let currentSearch = document.querySelector('#leaderboard.active>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getClanSearch/' + $userID, { search: lastSearch }, updateClanLeaderboardSearch);   
}

function updateClanLeaderboardSearch() {
    let reply = JSON.parse(this.responseText);

    let list = document.querySelector('#leaderboard.active>ol');
    list.innerHTML = "";

    let img = document.querySelector('img.img-fluid');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function(element) {
        list.innerHTML += 
            '<button data-id="/user/' + element.username + '" type="button" class="text-left list-group-item border-0 list-group-item-action">' + 
                '<li class="ml-3">' + 
                    '<div class="d-flex align-items-center row">' + 
                        '<div class="col-2 col-sm-1 friend-img">' + 
                            '<img alt="logo" width="48" src="' + path_header + '/avatars/' + 
                                        element.race + '_' + element.class + '_' + element.gender + '.bmp"' + 
                                ' class="border img-fluid rounded-circle">' + 
                        '</div>' +
                        '<div class="col-7 col-sm-6 text-left">' + element.name + '</div>' +
                        '<div class="col-3 col-sm-5 text-right">' + element.xp + '</div>' + 
                    '</div>' + 
                '</li>' + 
            '</button>';
    });
}

// ---------------------------------------------------------------------------------------------------------------------//

function userListHandler(reply, list, path_header) {

    reply.forEach(function(element) {

        list.innerHTML +=
            '<li class="list-group shadow-lg">' 
        +       '<button data-id="' +  element.username + '" type="button" class="text-left list-group-item list-group-item-action">'
        +           '<div class="d-flex align-items-center row">'
        +               '<div class="col-2 col-sm-1 friend-img">'
        +                   '<img src="' + path_header + '/avatars/'
        +                       element.race + '_' + element.class + '_' + element.gender + '.bmp"' + 'alt=logo' 
        +                   ' class="border bg-light img-fluid rounded-circle">'
        +               '</div>'
        +               '<div class="col-5 col-sm-6 pr-1">' + element.name + '</div>'
        //+               '<div class="col-5 col-sm-5 pl-1 text-right">' + element.date + '</div>'
        +           '</div>'
        +       '</button>'
        +   '</li>';
      });
}