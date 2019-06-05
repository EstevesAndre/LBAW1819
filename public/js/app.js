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

    let sendMessage = document.querySelector('#send-button');
    if (sendMessage) sendMessage.addEventListener('click', sendAddMessageRequest);

    let chatFriends = document.querySelectorAll('.friend-list');
    [].forEach.call(chatFriends, function (friend) {
        friend.addEventListener('click', updateChatRequest);
    });

    let scrool = document.getElementById('chatScroll');
    if (scrool) scrool.scrollTop = scrool.scrollHeight;

    let hasChat = document.querySelector('.has-chat');

    if (hasChat != null) {
        let auth_id = document.querySelector('.has-chat').id;
        let friend_id = document.querySelector('.friend-chat').id;

        Echo.private('chat' + auth_id) //TODO add receiver id to channel name
            .listen('MessageSent', (e) => {
                if (e.sender == friend_id) {
                    let message_area = document.querySelector('#chat-body');
                    message_area.innerHTML += '<div class="my-3 outgoing_msg"><div class="sent_msg"><p>' + reply.messages[i].message_text + '</p><span class="text-right mt-0 pt-0 time_date">' + reply.messages[i].date.substring(0, 10) + '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + reply.messages[i].date.substring(11, 19) + '</span></div></div>';

                }
            });
    }

    let openBanModal = document.querySelectorAll('.ban_member');
    [].forEach.call(openBanModal, function (member) {
        member.addEventListener('click', setBanModalID);
    });

    let unbanMember = document.querySelectorAll('.unban_member');
    [].forEach.call(unbanMember, function (blocked) {
        blocked.addEventListener('click', sendUnBanMemberRequest);
    });

    let invite = document.querySelector('.invite-users');
    if(invite) invite.addEventListener('click', addInviteRequest);

    let seeMoreHome = document.querySelector('section#posts .see-more');
    if(seeMoreHome) seeMoreHome.addEventListener('click', seeMorePostsRequest);

    // let generateButton = document.querySelector('.');
    // if (generateButton) generateButton.addEventListener('click', setCharacterInfo);

    let adminBanUsersModal = document.querySelectorAll('.ban_user');
    [].forEach.call(adminBanUsersModal, function (user) {
        user.addEventListener('click', setUserBanModalID);
    });

    let adminUnbanUsersModal = document.querySelectorAll('.unban_user');
    [].forEach.call(adminUnbanUsersModal, function (user) {
        user.addEventListener('click', setUserUnbanModalID);
    });

    let adminBanClansModal = document.querySelectorAll('.ban_clan');
    [].forEach.call(adminBanClansModal, function (clan) {
        clan.addEventListener('click', setClanBanModalID);
    });

    let adminUnbanClansModal = document.querySelectorAll('.unban_clan');
    [].forEach.call(adminUnbanClansModal, function (clan) {
        clan.addEventListener('click', setClanUnbanModalID);
    });

    let adminRmPermissionsModal = document.querySelectorAll('.rm_permissions');
    [].forEach.call(adminRmPermissionsModal, function (admin) {
        admin.addEventListener('click', setRmPermissionsModalID);
    });

    let adminAddPermissionsModal = document.querySelectorAll('.add_permissions');
    [].forEach.call(adminAddPermissionsModal, function (admin) {
        admin.addEventListener('click', sendAddAdminPermissionsRequest);
    });

    let removeFriendShip = document.querySelector('.friend-remove');
    if(removeFriendShip) removeFriendShip.addEventListener('click', removeFriendShipRequest);

    let sendFriendShip = document.querySelector('.friend-add');
    if(sendFriendShip) sendFriendShip.addEventListener('click', sendFriendShipRequest);

    let cancelFriendShip = document.querySelector('.friend-cancel');
    if(cancelFriendShip) cancelFriendShip.addEventListener('click', cancelFriendShipRequest);

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

    sendAjaxRequest('put', '/api/post', { content: content, clanID: clanID }, addedPostHanlder);
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

    let message = document.querySelector('#message-send>input');
    let input = message.value;
    message.value = '';
    let friend_id = document.querySelector('.friend-chat').id;

    if (input != "")
        sendAjaxRequest('put', '/api/chat/' + friend_id, { message: input }, addedMessageHandler);
}

function updateChatRequest(e) {
    e.preventDefault();
    console.log("Update chat request");
    let friend_id = e.target.closest("a.friend-list").getAttribute('id');

    sendAjaxRequest('post', '/api/update_chat/' + friend_id, null, updatedChatHandler);
}

function setBanModalID(e) {
    e.preventDefault();

    let id = e.target.id;
    let modal = document.querySelector('.ban_modal');

    modal.setAttribute('id', id);

    let modal_error = document.querySelector('#banModal .modal-body .error-msg');
    modal_error.innerHTML = "";

    let banMember = document.querySelector('.ban_modal');
    banMember.addEventListener('click', sendBanMemberRequest);
}

function setUserBanModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-ban-modal');
    modalSubmit.setAttribute('id', e.target.closest('button.ban_user').getAttribute('id'));
    modalSubmit.disabled = false;

    let modal_msg = document.querySelector('#banModal .modal-body .msg-response');
    modal_msg.innerHTML = "&nbsp";

    modalSubmit.addEventListener('click', sendBanUserRequest);
}

function setUserUnbanModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-unban-modal');
    modalSubmit.setAttribute('id', e.target.closest('button.unban_user').getAttribute('id'));
    modalSubmit.disabled = false;

    document.querySelector('#unbanModal>div>div>div.modal-body>p>small.end-date').innerHTML = e.target.closest('button.unban_user').getAttribute('ban-end-date');

    modalSubmit.addEventListener('click', sendUnbanUserRequest);
}

function setClanBanModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-ban-clan-modal');
    modalSubmit.setAttribute('id', e.target.closest('button.ban_clan').getAttribute('id'));
    modalSubmit.disabled = false;

    let modal_msg = document.querySelector('#clanBanModal .modal-body .msg-response');
    modal_msg.innerHTML = "&nbsp";

    modalSubmit.addEventListener('click', sendBanClanRequest);
}

function setClanUnbanModalID(e) {
    e.preventDefault();
    
    let modalSubmit = document.querySelector('.btn-unban-clan-modal');
    modalSubmit.setAttribute('id', e.target.closest('button.unban_clan').getAttribute('id'));
    modalSubmit.disabled = false;

    document.querySelector('#clanUnbanModal>div>div>div.modal-body>p>small.end-date').innerHTML = e.target.closest('button.unban_clan').getAttribute('ban-end-date');

    modalSubmit.addEventListener('click', sendUnbanClanRequest);
}

function setRmPermissionsModalID(e) {
    e.preventDefault();
    
    let modalSubmit = document.querySelector('.btn-rm-permissions-modal');
    modalSubmit.setAttribute('id', e.target.closest('button.rm_permissions').getAttribute('id'));
    modalSubmit.disabled = false;

    modalSubmit.addEventListener('click', sendRmPermissionsRequest);
}

function sendBanUserRequest(e) {
    e.preventDefault();
    let userID = e.target.closest('button.btn-ban-modal').getAttribute('id');
    let motives = document.querySelectorAll('#banModal .form-check-input');
    let checkedMotive = "";
    //get checked motive
    for (let i = 0; i < motives.length; i++) {
        if (motives[i].checked) {
            checkedMotive = motives[i].value;
            break;
        }
    }
    //at least one must be checked
    if (checkedMotive == "") {
        let modal_msg = document.querySelector('#banModal .modal-body .msg-response');
        modal_msg.innerHTML = 'Please select at least one motive!';
        return;
    }

    let durations = document.querySelectorAll('#banModal .modal-body .form-control option');
    let selectedDuration = "";
    //get selected duration
    for (let i = 0; i < durations.length; i++) {
        if (durations[i].selected) {
            selectedDuration = parseInt(durations[i].value);
            break;
        }
    }
    if (selectedDuration == 0) {
        let modal_msg = document.querySelector('#banModal .modal-body .msg-response');
        modal_msg.innerHTML = 'Please select a ban duration';
        return;
    }

    let formattedDate = selectedDuration;
    
    if(selectedDuration != -1){
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + selectedDuration);
        let date = endDate.toISOString().replace('Z', '').replace('T', ' ');
        formattedDate = date.substr(0, date.lastIndexOf('.'))
    }

    sendAjaxRequest('put', '/api/banUser/' + userID, { motive: checkedMotive, endDate: formattedDate }, banUserHandler);
} 

function sendUnbanUserRequest(e) {
    e.preventDefault();
    let userID = e.target.closest('button.btn-unban-modal').getAttribute('id');
    
    sendAjaxRequest('delete', '/api/unbanUser/' + userID, null, unbanUserHandler);
}

function sendBanClanRequest(e) {
    e.preventDefault();
    let clanID = e.target.closest('button.btn-ban-clan-modal').getAttribute('id');

    let motives = document.querySelectorAll('#clanBanModal .form-check-input');
    let checkedMotive = "";
    //get checked motive
    for (let i = 0; i < motives.length; i++) {
        if (motives[i].checked) {
            checkedMotive = motives[i].value;
            break;
        }
    }
    //at least one must be checked
    if (checkedMotive == "") {
        let modal_msg = document.querySelector('#clanBanModal .modal-body .msg-response');
        modal_msg.innerHTML = 'Please select at least one motive!';
        return;
    }

    let durations = document.querySelectorAll('#clanBanModal .modal-body .form-control option');
    let selectedDuration = "";
    //get selected duration
    for (let i = 0; i < durations.length; i++) {
        if (durations[i].selected) {
            selectedDuration = parseInt(durations[i].value);
            break;
        }
    }
    if (selectedDuration == 0) {
        let modal_msg = document.querySelector('#clanBanModal .modal-body .msg-response');
        modal_msg.innerHTML = 'Please select a ban duration';
        return;
    }

    let formattedDate = selectedDuration;
    
    if(selectedDuration != -1){
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + selectedDuration);
        let date = endDate.toISOString().replace('Z', '').replace('T', ' ');
        formattedDate = date.substr(0, date.lastIndexOf('.'))
    }
    
    sendAjaxRequest('put', '/api/banClan/' + clanID, { motive: checkedMotive, endDate: formattedDate }, banClanHandler);
}

function sendUnbanClanRequest(e) {
    e.preventDefault();
    let clanID = e.target.closest('button.btn-unban-clan-modal').getAttribute('id');
    
   sendAjaxRequest('delete', '/api/unbanClan/' + clanID, null, unbanClanHandler);
}

function sendRmPermissionsRequest(e) {
    e.preventDefault();
    let userID = e.target.closest('button.btn-rm-permissions-modal').getAttribute('id');
    
   sendAjaxRequest('delete', '/api/removePermissions/' + userID, null, removePermissionsHandler);
}

function sendAddAdminPermissionsRequest(e) {
    e.preventDefault();
    
    let checks = document.querySelectorAll('li.invite-list-user .checks');
    let checkedUser = "";

    //get checked motive
    for (let i = 0; i < checks.length; i++) {
        if (checks[i].checked) {
            checkedUser = checks[i].closest('li.invite-list-user').getAttribute('data-id');
            break;
        }
    }

    if(checkedUser == "") return;

    sendAjaxRequest('put', '/api/addPermissions/' + checkedUser, null, addPermissionsHandler);
}


function sendBanMemberRequest(e) {
    e.preventDefault();

    let member_id = e.target.id;
    let motives = document.querySelectorAll('.form-check-input');
    let checkedMotive = "";

    //get checked motive
    for (let i = 0; i < motives.length; i++) {
        if (motives[i].checked) {
            checkedMotive = motives[i].value;
            break;
        }
    }

    //at least one must be checked
    if (checkedMotive == "") {
        let modal_error = document.querySelector('#banModal .modal-body .error-msg');
        modal_error.innerHTML = 'Please select at least one motive!';
        return;
    }

    let durations = document.querySelectorAll('.modal-body .form-control option');
    let selectedDuration = "";

    //get selected duration
    for (let i = 0; i < durations.length; i++) {
        if (durations[i].selected) {
            selectedDuration = parseInt(durations[i].value);
            break;
        }
    }

    if (selectedDuration == 0) {
        let modal_error = document.querySelector('#banModal .modal-body .error-msg');
        modal_error.innerHTML = 'Please select a ban duration';
        return;
    }

    let formattedDate = selectedDuration;
    
    if(selectedDuration != -1){
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + selectedDuration);

        let date = endDate.toISOString().replace('Z', '').replace('T', ' ');
        formattedDate = date.substr(0, date.lastIndexOf('.'));

        
    }

    sendAjaxRequest('put', '/api/banMember/' + member_id, { motive: checkedMotive, endDate: formattedDate }, banMemberHandler);
}

function sendUnBanMemberRequest(e) {
    e.preventDefault();
    let blocked_id = e.target.id;
    let clan_id = document.querySelector('.settings').getAttribute('data-id');

    sendAjaxRequest('put', '/api/unbanMember/' + blocked_id + '+' + clan_id, null, unbanMemberHandler);
}

function addInviteRequest(e){
    e.preventDefault();

    let users = document.querySelectorAll('.invite-list-user input');
    let clan_id = parseInt(document.querySelector('.invite-list').getAttribute('data-id'));

    let invited_users = [];
    let invited_count = 0;

    for(let i= 0; i < users.length; i++){
        if(users[i].checked){
            invited_users.push(parseInt(users[i].parentElement.parentElement.parentElement.getAttribute('data-id')));
            invited_count++;
        }
    }

    if(invited_count == 0){
        return;
    }
    console.log(invited_users);
    sendAjaxRequest('post', '/api/inviteUsers/' + clan_id, {invites: invited_users}, addedInvitesHandler);
    
}

function seeMorePostsRequest(e){
    console.log(e.target);

    let current_page = parseInt(document.querySelector('section#posts').getAttribute('data-count'));

    console.log(current_page);
    
    sendAjaxRequest('get', '/api/seeMoreHome/' + current_page, null, addedMoreHomeHandler);

}

function removeFriendShipRequest(e){
    console.log('remove');
    let friend_id = parseInt(e.target.closest('.friend-remove').getAttribute('data-id'));

    sendAjaxRequest('put', '/api/removeFriend/' + friend_id, null, removedFriendHandler);
}

function sendFriendShipRequest(e){
    console.log('send');
    let friend_id = parseInt(e.target.closest('.friend-add').getAttribute('data-id'));

    sendAjaxRequest('post', '/api/sendFriend/' + friend_id, null, sentFriendHandler);
}

function cancelFriendShipRequest(e){
    console.log('cancel');
    let friend_id = parseInt(e.target.closest('.friend-cancel').getAttribute('data-id'));

    sendAjaxRequest('post', '/api/cancelFriend/' + friend_id, null, cancelledFriendHandler);
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
    document.querySelector('.search-comment input').value = "";
    let comment_img = document.querySelector('.cardbox-heading>.media>div>a>img');
    let current_comms = comment_area.innerHTML;

    let path = comment_img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));
    console.log(comment_area);
    comment_area.innerHTML = 
        '<div class="d-flex align-items-center comment" id="' + comment.id + '">'
    +       '<span class="comment-avatar float-left mr-2">'
    +           '<a href="/user/' + comment.username + '">'
    +               '<img class="rounded-circle bg-warning" src="' + path_header + '/avatars/' + comment.race + '_' + comment.class + '_' + comment.gender + '.bmp" alt="Avatar">'
    +           '</a>'
    +       '</span>'
    +       '<div class="w-90 comment-data pl-1 pr-0">'
    +           '<p class="pt-3">' + comment.comment_text + '</p>'
    +       '</div>'
    +       '<span class="ml-2 delete-comment" id="' + comment.id + '">'
    +           '<a><i class="fas fa-times"></i></a>'
    +       '</span>'
    +   '</div>';

    comment_area.innerHTML  += current_comms;

    let deleteComment = document.querySelectorAll('.delete-comment>a>i');
    [].forEach.call(deleteComment, function (delCom) {
        delCom.addEventListener('click', sendDeleteCommentRequest);
    });
}

function addedMessageHandler() {

    let message = JSON.parse(this.responseText);
    let message_area = document.querySelector('#chatScroll');
    message_area.innerHTML += getChatMessage(message.message_text, message.date.substring(0,10), message.date.substring(11,19));

    let scrool = document.getElementById('chatScroll');
    if (scrool) scrool.scrollTop = scrool.scrollHeight;
}

function updatedChatHandler() {

    let reply = JSON.parse(this.responseText);

    let friend_id = document.querySelector('.friend-chat');
    let friend_names = document.querySelector('.friend-chat a');
    let friend_img = document.querySelector('.friend-chat img');

    let path = friend_img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    friend_id.setAttribute('id', reply.friend_info.id);
    friend_names.setAttribute('href', '/user/' + reply.friend_info.username);
    friend_names.innerHTML = reply.friend_info.name;
    friend_img.setAttribute('src', path_header + '/avatars/' + reply.friend_info.race + "_" + reply.friend_info.class + '_' + reply.friend_info.gender + '.bmp');

    let message_area = document.querySelector('#chatScroll');
    message_area.innerHTML = "";
    
    if(reply.messages.length > 7)
        message_area.innerHTML = '<div class="text-center">'
        +   '<button type="button" class="btn btn-sm bg-secondary border-0 rounded-circle my-1">'
        +        '<i class="fas fa-chevron-up"></i>'
        +   '</button>'
        + '</div>';


    for (let i = 0; i < reply.messages.length; i++) {
        message_area.innerHTML += getChatMessage(reply.messages[i].message_text, reply.messages[i].date.substring(0,10), reply.messages[i].date.substring(11,19));
    }
    let scrool = document.getElementById('chatScroll');
    if (scrool) scrool.scrollTop = scrool.scrollHeight;
}

function getChatMessage(text, date1, date2) {
    return  '<div class="my-3 outgoing_msg">'
        +       '<div class="sent_msg w-50 text-right mr-2">'
        +           '<p>' + text + '</p>'
        +           '<span class="text-right mt-0 pt-0 time_date">' + date1
        +               '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + date2
        +               '&nbsp&nbsp'
        +           '</span>'
        +       '</div>'
        +   '</div>';
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

    reply.users.forEach(function (element) {

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

function banUserHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let modal_msg = document.querySelector('#banModal .modal-body .msg-response');
    modal_msg.innerHTML = "User banned!";
    let banButton = document.querySelector('#banModal .modal-body .btn-ban-modal');
    banButton.disabled = true;
    
    let active_list = document.querySelector('ul.users-active'); //list of active users
    let banned_list = document.querySelector('ul.users-banned'); //list of banned users

    let active_banned = active_list.querySelector('li[data-id="' + reply.blocked.user_id + '"]'); //user in active list that was banned
    
    if(active_banned == null) return; // error occurred

    active_list.removeChild(active_banned);

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    banned_list.insertAdjacentHTML("afterbegin", getUnbanUserHTML(reply.user, path_header));

    let adminUnbanUsersModal = document.querySelectorAll('.unban_user');
    [].forEach.call(adminUnbanUsersModal, function (user) {
        user.addEventListener('click', setUserUnbanModalID);
    });
}

function unbanUserHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let banButton = document.querySelector('#unbanModal .modal-body .btn-unban-modal');
    banButton.disabled = true;
    
    let active_list = document.querySelector('ul.users-active'); //list of active users
    let banned_list = document.querySelector('ul.users-banned'); //list of banned users

    let unbanned = banned_list.querySelector('li[data-id="' + reply.user.id + '"]'); //user in active list that was banned
    
    if(unbanned == null) return; // error occurred

    banned_list.removeChild(unbanned);

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let userID = img.getAttribute('data-id');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    active_list.insertAdjacentHTML("afterbegin", getActiveUserHTML(reply.user, path_header, userID));

    let adminBanUsersModal = document.querySelectorAll('.ban_user');
    [].forEach.call(adminBanUsersModal, function (user) {
        user.addEventListener('click', setUserBanModalID);
    });
}

function banClanHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let modal_msg = document.querySelector('#clanBanModal .modal-body .msg-response');
    modal_msg.innerHTML = "Clan banned!";
    let banButton = document.querySelector('#clanBanModal .modal-body .btn-ban-clan-modal');
    banButton.disabled = true;
    
    let active_list = document.querySelector('ul.clans-active'); //list of active clans
    let banned_list = document.querySelector('ul.clans-banned'); //list of banned clans

    let active_banned = active_list.querySelector('li[data-id="' + reply.blocked.clan + '"]'); //clan in active list that was banned

    if(active_banned == null) return; // error occurred

    active_list.removeChild(active_banned);

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    console.log(banned_list);
    console.log(reply);
    console.log(path_header);
    banned_list.insertAdjacentHTML("afterbegin", getUnbanClanHTML(reply.clan, path_header));

    let adminUnbanClansModal = document.querySelectorAll('.unban_clan');
    [].forEach.call(adminUnbanClansModal, function (clan) {
        clan.addEventListener('click', setClanUnbanModalID);
    });
}

function unbanClanHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let banButton = document.querySelector('#clanUnbanModal .modal-body .btn-unban-clan-modal');
    banButton.disabled = true;
    
    let active_list = document.querySelector('ul.clans-active'); //list of active clans
    let banned_list = document.querySelector('ul.clans-banned'); //list of banned clans

    let unbanned = banned_list.querySelector('li[data-id="' + reply.clan.id + '"]'); //user in active list that was banned
    
    if(unbanned == null) return; // error occurred

    banned_list.removeChild(unbanned);

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    active_list.insertAdjacentHTML("afterbegin", getActiveClanHTML(reply.clan, path_header));

    let adminBanClansModal = document.querySelectorAll('.ban_clan');
    [].forEach.call(adminBanClansModal, function (clan) {
        clan.addEventListener('click', setClanBanModalID);
    });
}

function removePermissionsHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let removeButton = document.querySelector('#removePermModal .modal-body .btn-rm-permissions-modal');
    removeButton.disabled = true;
    
    let active_admins = document.querySelector('ul.admins-active'); //list of active clans

    let removed = active_admins.querySelector('li[data-id="' + reply.id + '"]'); //user in active list that was banned
    
    if(removed == null) return; // error occurred
    active_admins.removeChild(removed);
}

function addPermissionsHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let active_admins = document.querySelector('ul.admins-active');
    let not_admins = document.querySelector('ul.not-admin-users');

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let userID = img.getAttribute('data-id');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    let added = not_admins.querySelector('li.invite-list-user[data-id="' + reply.id + '"]');
    
    if(added == null) return; // error occurred
    not_admins.removeChild(added);

    active_admins.insertAdjacentHTML("afterbegin", getActiveAdminPermissionsHTML(reply, path_header, userID));

    let adminRmPermissionsModal = document.querySelectorAll('.rm_permissions');
    [].forEach.call(adminRmPermissionsModal, function (admin) {
        admin.addEventListener('click', setRmPermissionsModalID);
    });
}

function banMemberHandler(){
    
    let reply = JSON.parse(this.responseText);
    let banned = reply.banned;    

    let active_list = document.querySelector('ul.active'); //list of active members
    let banned_list = document.querySelector('ul.banned'); //list of banned members
    let active_banned = document.querySelector('ul.active [data-id="' + banned.id + '"]'); //member in active list that was banned

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    active_list.removeChild(active_banned);

    banned_list.insertAdjacentHTML("afterbegin",'<li class="p-2 ml-3" data-id="' + banned.id + '">' + 
                            '<div class="d-flex align-items-center row">' + 
                                '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">' + 
                                    '<img width="40" class="border bg-warning img-fluid rounded-circle border"' + 
                                    'src="' + path_header + '/avatars/' + banned.race + '_' + banned.class + '_' + banned.gender + '.bmp" alt="Clan">' + 
                                '</div>' + 
                                '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../user/' + banned.username + '">' + banned.name + '</a></div>' + 
                                '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">' + 
                                   '<button type="button" class="unban_member btn btn-success btn-sm" id="' + banned.id +'">' + 
                                        '<i class="fas fa-user-plus"></i> Unban Member' + 
                                    '</button>' + 
                                '</div>' + 
                            '</div>' + 
                        '</li>');

    let unbanMember = document.querySelectorAll('.unban_member');
    [].forEach.call(unbanMember, function (blocked) {
        blocked.addEventListener('click', sendUnBanMemberRequest);
    });
}

function unbanMemberHandler(){
    
    let reply = JSON.parse(this.responseText);
    let unbanned = reply.unbanned;    

    let active_list = document.querySelector('ul.active'); //list of active members
    let banned_list = document.querySelector('ul.banned'); //list of banned members
    let banned_active = document.querySelector('ul.banned [data-id="' + unbanned.id + '"]'); //member in banned list that was unbanned

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    console.log(banned_active);

    banned_list.removeChild(banned_active);

    active_list.insertAdjacentHTML("afterbegin",'<li class="p-2 ml-3" data-id="' + unbanned.id + '">' + 
                            '<div class="d-flex align-items-center row">' + 
                                '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">' + 
                                    '<img width="40" class="border bg-warning img-fluid rounded-circle border"' + 
                                    'src="' + path_header + '/avatars/' + unbanned.race + '_' + unbanned.class + '_' + unbanned.gender + '.bmp" alt="Clan">' + 
                                '</div>' + 
                                '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="../user/' + unbanned.username + '">' + unbanned.name + '</a></div>' + 
                                '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">' + 
                                   '<button type="button" class="unban_member btn btn-danger btn-sm" id="' + unbanned.id +'">' + 
                                        '<i class="fas fa-user-times"></i> Ban Member' + 
                                    '</button>' + 
                                '</div>' + 
                            '</div>' + 
                        '</li>');

    let banMember = document.querySelectorAll('.ban_member');
    [].forEach.call(banMember, function (blocked) {
        blocked.addEventListener('click', sendBanMemberRequest);
    });
}
// ---------------------------------------------------------------------------------------------------------------------//

function clanMembersSearch($clanID) 
{
    let currentSearch = document.querySelector('#members.active>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getClanSearch/' + $clanID, { search: lastSearch }, updateClanMembersSearch);   
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

function addedInvitesHandler(){
    let reply = JSON.parse(this.responseText);
    let invited_users = reply.invited.split(',');

    let invite_list =  document.querySelector('.invite-list');
    
    for(let i = 0; i < invited_users.length; i++){
        console.log(invited_users[i]);
        let invited = document.querySelector('.invite-list-user[data-id="' + parseInt(invited_users[i]) + '"]');
        console.log(invited);
        invite_list.removeChild(invited);
    }
}
// ---------------------------------------------------------------------------------------------------------------------//

function activeUsersSearch() {
    let currentSearch = document.querySelector('#active>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getActiveUsersSearch', { search: lastSearch }, updateActiveUsersSearch);   
}

function bannedUsersSearch() {
    let currentSearch = document.querySelector('#banned>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getBannedUsersSearch', { search: lastSearch }, updateBannedUsersSearch);   
}

function updateActiveUsersSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let users = document.querySelector('#users-content>div.active>ul');
    users.innerHTML = "";

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let userID = img.getAttribute('data-id');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function(element) {
        users.innerHTML += getActiveUserHTML(element, path_header, userID);
    });

    let adminBanUsersModal = document.querySelectorAll('.ban_user');
    [].forEach.call(adminBanUsersModal, function (user) {
        user.addEventListener('click', setUserBanModalID);
    });
}

function updateBannedUsersSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let users = document.querySelector('#users-content>div.active>ul');
    users.innerHTML = "";

    let path = document.querySelector('#nav-user-img').getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function(element) {
        users.innerHTML += getUnbanUserHTML(element, path_header);
    });

    let adminUnbanUsersModal = document.querySelectorAll('.unban_user');
    [].forEach.call(adminUnbanUsersModal, function (user) {
        user.addEventListener('click', setUserUnbanModalID);
    });
}

function getActiveUserHTML(element, path_header, userID) {
    let button = "";
        if(element.id == userID) button = '<button type="button" class="btn btn-danger btn-sm" disabled>';
        else button = '<button type="button" class="ban_user btn btn-danger btn-sm" id="' + element.id + '" data-toggle="modal" data-target="#banModal">'

    return '<li class="p-2 ml-4" data-id="' + element.id + '">'
    +   '<div class="d-flex align-items-center row">'
    +       '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
    +           '<img width="50" class="border img-fluid rounded-circle" alt="Clan"'
    +               'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
    +       '</div>'
    +       '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="user/' + element.username + '">'  + element.name + '</a></div>'
    +       '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
    +           button
    +               '<i class="fas fa-user-times"></i> Ban User'
    +           '</button>'
    +       '</div>'
    +   '</div>'
    + '</li>';
}

function getUnbanUserHTML(element, path_header) {
    return '<li class="p-2 ml-4" data-id="' + element.id + '">'
    +   '<div class="d-flex align-items-center row">'
    +       '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
    +           '<img width="50" class="border img-fluid rounded-circle" alt="Clan"'
    +               'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
    +       '</div>'
    +       '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="user/' + element.username + '">'  + element.name + '</a></div>'
    +       '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
    +           '<button type="button" class="unban_user btn btn-success btn-sm" id="' + element.id +'" data-toggle="modal" data-target="#unbanModal">'
    +               '<i class="fas fa-user-times"></i> Unban User'
    +           '</button>'
    +       '</div>'
    +   '</div>'
    +'</li>';
}

// ---------------------------------------------------------------------------------------------------------------------//

function activeClansSearch() {
    let currentSearch = document.querySelector('#active-clans>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getActiveClansSearch', { search: lastSearch }, updateActiveClansSearch);   
}

function bannedClansSearch() {
    let currentSearch = document.querySelector('#banned-clans>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getBannedClansSearch', { search: lastSearch }, updateBannedsClansSearch);   
}

function updateActiveClansSearch() {
    let reply = JSON.parse(this.responseText);

    let users = document.querySelector('#clans-content>div.active>ul');
    users.innerHTML = "";

    let path = document.querySelector('#nav-user-img').getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function(element) {
        users.innerHTML += getActiveClanHTML(element, path_header);
    });
}

function getActiveClanHTML(element, path_header) {
    return '<li class="p-2 ml-3" data-id="' + element.id + '">'
    +   '<div class="d-flex align-items-center row">'
    +       '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
    +           '<img width="50" class="border img-fluid rounded-circle border" alt="Clan" src="' + path_header + '/clanImgs/'+ element.id+'.jpg' + '">'
    +       '</div>'
    +       '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="clan/' + element.id + '">' + element.name + '</a></div>'
    +       '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
    +           '<button type="button" class="ban_clan btn btn-danger btn-sm" data-toggle="modal" data-target="#clanBanModal">'
    +               '<i class="fas fa-user-times"></i> Ban Clan'
    +           '</button>'
    +       '</div>'
    +   '</div>'
    +'</li>';
}

function updateBannedsClansSearch() {
    let reply = JSON.parse(this.responseText);

    let users = document.querySelector('#clans-content>div.active>ul');
    users.innerHTML = "";

    let path = document.querySelector('#nav-user-img').getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));


    reply.forEach(function(element) {
        users.innerHTML += getUnbanClanHTML(element, path_header);
    });

    let adminUnbanClansModal = document.querySelectorAll('.unban_clan');
    [].forEach.call(adminUnbanClansModal, function (clan) {
        clan.addEventListener('click', setClanUnbanModalID);
    });
}

function getUnbanClanHTML(element, path_header) {
    return '<li class="p-2 ml-3" data-id="' + element.id + '">'
    +   '<div class="d-flex align-items-center row">'
    +       '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
    +           '<img width="50" class="border img-fluid rounded-circle border" alt="Clan" src="' + path_header + '/clanImgs/'+element.id+'.jpg' + '">'
    +       '</div>'
    +       '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="clan/' + element.id + '">' + element.name + '</a></div>'
    +       '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
    +           '<button type="button" class="unban_clan btn btn-success btn-sm" id="' + element.id + '" data-toggle="modal" data-target="#clanUnbanModal">'
    +               '<i class="fas fa-user-times"></i> Unban Clan'
    +           '</button>'
    +       '</div>'
    +   '</div>'
    +'</li>';
}

// ---------------------------------------------------------------------------------------------------------------------//

function activeAdminsSearch() {
    let currentSearch = document.querySelector('#admins-content>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getActiveAdminsSearch', { search: lastSearch }, updateActiveAdminsSearch);   
}

function potentialAdminsSearch() {
    let currentSearch = document.querySelector('#addModal>div>div>div.modal-body>div>div.searchbar>input').value;
    if(lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getPotentialAdminsSearch', { search: lastSearch }, updatePotentialAdminsSearch);   
}

function updateActiveAdminsSearch() {
    let reply = JSON.parse(this.responseText);

    let users = document.querySelector('#v-pills-administrators>ul');
    users.innerHTML = "";

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let userID = img.getAttribute('data-id');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function(element) {
        users.innerHTML += getActiveAdminPermissionsHTML(element, path_header, userID)
    });
}

function getActiveAdminPermissionsHTML(element, path_header, userID) {
    let button = "";
    if(element.id == userID) button = '<button type="button" class="btn btn-danger btn-sm" disabled>';
    else button = '<button type="button" class="rm_permissions btn btn-danger btn-sm" id="' + element.id + '" data-toggle="modal" data-target="#removePermModal">';

    return '<li class="p-2 ml-3" data-id="' + element.id + '">'
        +            '<div class="d-flex align-items-center row">'
        +                '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        +                    '<img width="50" class="border img-fluid rounded-circle border"'
        +                      'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
        +                '</div>'
        +                '<div class="col-5 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="⁄user/' + element.username + '">' + element.name + '</a></div>'
        +                '<div class="col-4 col-sm-4 col-md-4 px-0 text-right">'
        +                    button
        +                        '<i class="fas fa-user-times"></i> Remove Permissions'
        +                    '</button>'
        +                '</div>'
        +           '</div>'
        +        '</li>';
}

function updatePotentialAdminsSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let users = document.querySelector('#addModal>div>div>div.modal-body>ul');
    users.innerHTML = "";

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function(element) {
        users.innerHTML += 
            '<li class="invite-list-user p-2 ml-3" data-id="' + element.id + '">'
        +        '<div class="d-flex align-items-center row">'
        +           '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        +                '<img width="40" class="border img-fluid rounded-circle border" alt="User"'
        +                    'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
        +            '</div>'
        +            '<div class="col-7 col-sm-6 col-md-7 pr-1 text-left">'
        +                '<a class="no-hover standard-text" href="user/' + element.username + '">' + element.name + '</a>'
        +            '</div>'
        +            '<div class="col-2 col-sm-3 col-md-3 px-0 text-right">'
        +                '<input class="checks" name="new-admin" type="radio">'
        +                '<span class="checkmark"></span>'
        +            '</div>'
        +        '</div>'
        +    '</li>'
    });
}
// ---------------------------------------------------------------------------------------------------------------------//


function addedMoreHomeHandler(){
    let reply = JSON.parse(this.responseText);
    console.log(reply);
    console.log(reply.posts.current_page);
    console.log();

    let current_page = reply.posts.current_page + 1;
    document.querySelector('section#posts').setAttribute('data-count',current_page);

    let posts = reply.posts.data;
    let posts_div = document.querySelector('section#posts');
    
    // for(let i = 0; i < posts.length; i++){
    //     posts_div.innerHTML += 
    // }
}

function removedFriendHandler(){
    
    let reply = JSON.parse(this.responseText);
    let old_button = document.querySelector('.friend-remove');
    let friend = document.querySelector('.friend-remove').getAttribute('data-id');
    let new_button = "";
    
    if(reply.can_send){
        new_button =  '<button type="button" class="friend-add col-sm-12 mt-5 btn btn-outline-success" data-id="' + friend + '">'
        + 'Add as Friend <i class="fas fa-user-plus"></i>'
        + '</button>';

        old_button.outerHTML = new_button;

        let newEvent = document.querySelector('.friend-add');
        if(newEvent) newEvent.addEventListener('click', sendFriendShipRequest);
    }
    else{
        new_button =  '<button type="button" class="col-sm-12 mt-5 btn btn-secondary" data-id="' + friend + '" disabled> '
        + '<i class="fas fa-user-slash"></i>'
        + '</button>';

        old_button.outerHTML = new_button;
    }    
}

function sentFriendHandler(){
    let old_button = document.querySelector('.friend-add');
    let friend = document.querySelector('.friend-add').getAttribute('data-id');
    let new_button =  '<button type="button" class="friend-cancel col-sm-12 mt-5 btn btn-danger" data-id="' + friend + '"> '
            + 'Cancel Request <i class="fas fa-times"></i>'
            + '</button>';

    old_button.outerHTML = new_button;

    let newEvent = document.querySelector('.friend-cancel');
    if(newEvent) newEvent.addEventListener('click', cancelFriendShipRequest);

}

function cancelledFriendHandler(){
    let old_button = document.querySelector('.friend-cancel');
    let friend = document.querySelector('.friend-cancel').getAttribute('data-id');
    let new_button =  '<button type="button" class="friend-add col-sm-12 mt-5 btn btn-outline-success" data-id="' + friend + '"> '
            + 'Add as Friend <i class="fas fa-user-plus"></i>'
            + '</button>';

    old_button.outerHTML = new_button;

    let newEvent = document.querySelector('.friend-add');
    if(newEvent) newEvent.addEventListener('click', sendFriendShipRequest);

}