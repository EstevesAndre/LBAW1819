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
    
    /*$("div.post").hover(function() {
        $post_id = $(this)[0].getAttribute('data-id');
        addEventListener('click', function() {
            window.location.href = "/post/" + $post_id;
        })
    });*/
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

    sendAjaxRequest('put', '/api/post', { content: content }, addedPostHanlder);
}

function sendDeletePostRequest(e) {
    console.log("Post delete request");

    let post_id = this.closest('div.postModal').getAttribute('data-id');

    if (post_id == null)
        return;

    sendAjaxRequest('delete', '/api/post/' + post_id, null, deletedPostHandler);
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

    let input = document.querySelector('#message-send > input').value;
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
    let current_comms = comment_area.innerHTML;
    comment_area.innerHTML = '<div class="d-flex align-items-center" id="' + comment.id + '"><span class="comment-avatar float-left mr-2"><a href="/user/' + comment.user_id + '"><img class="rounded-circle bg-warning" src="/assets/logo.png" alt="Avatar"></a></span><div class="comment-data pl-1 pr-0"><p class="pt-3">' + comment.comment_text + '</p></div></div>';
    comment_area.innerHTML  += current_comms;
}

function addedMessageHandler() {
    
    let message = JSON.parse(this.responseText);
    let message_area = document.querySelector('#chat-body');
    message_area.innerHTML += '<div class="my-3 outgoing_msg"><div class="sent_msg"><p>' + message.message_text +'</p><span class="text-right mt-0 pt-0 time_date">' + message.date.date.substring(0, 10) + '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + message.date.date.substring(11, 19) + '</span></div></div>';
}

function updatedChatHandler(){
    
    let reply = JSON.parse(this.responseText);
    
    let friend_id = document.querySelector('.friend-chat');
    let friend_names = document.querySelector('.friend-chat a');

    friend_id.setAttribute('id', reply.friend_info[0].id);
    friend_names.setAttribute('href', '/user/' + reply.friend_info[0].username);
    friend_names.innerHTML = reply.friend_info[0].name;
    
    let message_area = document.querySelector('#chat-body');
    message_area.innerHTML = "";  
    for(let i = 0; i < reply.messages.length;i++){
        message_area.innerHTML += '<div class="my-3 outgoing_msg"><div class="sent_msg"><p>' + reply.messages[i].message_text +'</p><span class="text-right mt-0 pt-0 time_date">' + reply.messages[i].date.substring(0, 10) + '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + reply.messages[i].date.substring(11, 19) + '</span></div></div>';
    }

}

addEventListeners();