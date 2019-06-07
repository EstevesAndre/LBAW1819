function addEventListeners() {

    let deleteLike = document.querySelectorAll('li>a>i.fa-thumbs-up.active');
    [].forEach.call(deleteLike, function (like) {
        like.addEventListener('click', sendDeleteLikeRequest);
    });
    let addLike = document.querySelectorAll('li>a>i.fa-thumbs-up:not(.active)');
    [].forEach.call(addLike, function (like) {
        like.addEventListener('click', sendAddLikeRequest);
    });

    let friendList = document.querySelectorAll('#friends>ul>li>button, #members>ul>li>button, #leaderboard-content>div.to_link ol>button, #leaderboard-content>div.to_link div.podium, #leaderboard>ol>button');
    [].forEach.call(friendList, function (friend) {
        friend.addEventListener('click', function () {
            window.location.href = this.getAttribute('data-id');
        });
    });

    let postModal = document.querySelectorAll('div.postModal>div>div>div.modal-body>div>button.btn-danger');
    [].forEach.call(postModal, function (delPost) {
        delPost.addEventListener('click', sendDeletePostRequest);
    });

    let sharedPostModal = document.querySelectorAll('div.sharedPostModal button.btn-delete-share');
    [].forEach.call(sharedPostModal, function (delShare) {
        delShare.addEventListener('click', sendDeleteShareRequest);
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

    let openBanModal = document.querySelectorAll('.ban_member');
    [].forEach.call(openBanModal, function (member) {
        member.addEventListener('click', setBanModalID);
    });

    let unbanMember = document.querySelectorAll('.unban_member');
    [].forEach.call(unbanMember, function (blocked) {
        blocked.addEventListener('click', sendUnBanMemberRequest);
    });

    let invite = document.querySelector('.invite-users');
    if (invite) invite.addEventListener('click', addInviteRequest);

    let seeMoreHome = document.querySelector('section#posts .see-more');
    if (seeMoreHome) seeMoreHome.addEventListener('click', seeMorePostsRequest);

    // let generateButton = document.querySelector('.');
    // if (generateButton) generateButton.addEventListener('click', setCharacterInfo);

    let adminBanUsersModal = document.querySelectorAll('.ban_user');
    [].forEach.call(adminBanUsersModal, function (user) {
        user.addEventListener('click', setUserBanModalID);
    });

    let adminReportDismiss = document.querySelectorAll('.dismiss');
    [].forEach.call(adminReportDismiss, function (user) {
        user.addEventListener('click', adminReportDismissRequest);
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

    let removeFriendShip = document.querySelector('.profile .friend-remove');
    if (removeFriendShip) removeFriendShip.addEventListener('click', removeFriendShipRequest);

    let sendFriendShip = document.querySelector('.profile .friend-add');
    if (sendFriendShip) sendFriendShip.addEventListener('click', sendFriendShipRequest);

    let cancelFriendShip = document.querySelector('.profile .friend-cancel');
    if (cancelFriendShip) cancelFriendShip.addEventListener('click', cancelFriendShipRequest);

    let cancelFriendShipRequestPage = document.querySelectorAll('.friend-cancel-rp .friend-cancel');
    [].forEach.call(cancelFriendShipRequestPage, function (answer) {
        answer.addEventListener('click', cancelFriendShipRPRequest);
    });

    let answerFriendShip = document.querySelectorAll('.profile .friend-accept, .profile .friend-decline');
    [].forEach.call(answerFriendShip, function (answer) {
        answer.addEventListener('click', answerFriendShipRequest);
    });

    let answerFriendShipRequestPage = document.querySelectorAll('.friend-answer-rp .friend-accept,.friend-answer-rp .friend-decline');
    [].forEach.call(answerFriendShipRequestPage, function (answer) {
        answer.addEventListener('click', answerFriendShipRPRequest);
    });

    let answerClanRequestPage = document.querySelectorAll('.friend-answer-rp .clan-accept,.friend-answer-rp .clan-decline');
    [].forEach.call(answerClanRequestPage, function (answer) {
        answer.addEventListener('click', answerClanRPRequest);
    });

    let messageBox = document.getElementById("message-box");
    if(messageBox) messageBox.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("send-button").click();
        }
    });

    let commentBox = document.getElementById("comment-box");
    if(commentBox) commentBox.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("send-comment").click();
        }
    });

    let hasChat = document.querySelector('.has-chat');

    if (hasChat != null) {
        // let auth_id = document.querySelector('.has-chat').id;
        // let friend_id = document.querySelector('.friend-chat').id;

        // it doest work
        // Echo.private('chat' + auth_id) //TODO add receiver id to channel name
        //     .listen('MessageSent', (e) => {
        //         if (e.sender == friend_id) {
        //             let message_area = document.querySelector('#chatScroll');
        //             message_area.innerHTML += '<div class="my-3 outgoing_msg"><div class="sent_msg"><p>' + reply.messages[i].message_text + '</p><span class="text-right mt-0 pt-0 time_date">' + reply.messages[i].date.substring(0, 10) + '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + reply.messages[i].date.substring(11, 19) + '</span></div></div>';

        //         }
        //     });
    }

    let report = document.querySelectorAll('.reportModal .report');
    [].forEach.call(report, function (answer) {
        answer.addEventListener('click', reportPostRequest);
    });

    let buttonLinks = document.querySelectorAll('button.a-link');
    [].forEach.call(buttonLinks, function (link) {
        link.addEventListener('click', function () {
            window.location.href = this.getAttribute('value');
        });
    });

    let morePosts = document.querySelector('div.more-user-posts');
    if(morePosts) morePosts.addEventListener('click', sendMorePostsRequest);
}

function addHelpDeskText() {
    $(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    let navHelp = document.querySelector('.nav-help');
    let feedHelp = document.querySelector('.feed-help');
    let friendRequestsHelp = document.querySelector('.friend-requests-help');
    let clanHelp = document.querySelector('.clan-help');
    let clanSettingsHelp = document.querySelector('.clan-settings-help');
    let clanFeedHelp = document.querySelector('.clan-feed-help');
    let leaderBoardsHelp = document.querySelector('.leader-boards-help');
    let profileHelp = document.querySelector('.profile-help');
    let profileFeedHelp = document.querySelector('.profile-feed-help');
    let postHelp = document.querySelector('.post-help');
    let chatHelp = document.querySelector('.chat-help');


    if(navHelp) navHelp.title = "<p>" +
                    "Is your first time as an AlterEgo member? Are you lost? Don't worry! " +
                    "At this navigation bar you can access all website pages and features you need." +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "   <li>AlterEgo: the home page</li>" +
                    "   <li>Profile: your personal page</li>" + 
                    "   <li>Clan: the page of the clan which you are a member of (in case you joined one)</li>" +
                    "   <li>LeaderBoards: website podium with highest rated users.</li>" +
                    "</ul>" +
                    "<br>" +
                    "<a>" +
                    "   <i class='fas fa-user-friends'></i> See friend requests" +
                    "</a>" + 
                    "<br>" +
                    "<a>" +
                    "   <i class='far fa-envelope'></i> Go to chat" +
                    "<a>" +
                    "<br>" +
                    "<a>" +
                    "   <i class='far fa-bell'></i> See notifications" +
                    "<a>" +
                    "<br>" +
                    "<a>" +
                    "   <i class='fas fa-caret-down'></i> Create clan or logout" +
                    "<a>";

    if (feedHelp) {
        feedHelp.title = 
                    "<p>" +
                    "Welcome to the Feed! Here you can see all your friends posts and interact with them! " +
                    "Now you're a member of our community! Don't be shy... Feel free to:" +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "   <li>Make your own posts and share your thoughs (click the left button)</li>" +
                    "   <li>See your friends posts as well as yours (scroll down)</li>" +
                    "   <li>Like, comment and share any post you want</li>" +
                    "   <li>Quickly send and receive messages to/from your friends in the sidebar chat (at the right)</li>" +
                    "</ul>"; 
    }
    
    if (friendRequestsHelp) {
        friendRequestsHelp.title = 
                    "<p>This page will keep you informed about all made/received friend requests till now.</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "   <li>Sent requests: in case you want to cancel one.</li>" +
                    "   <li>Received requests: in case you want to answer one.</li>" +
                    "   <li>Rejected requests: whose senders cannot friend request you again.</li>" +
                    "</ul>";
    }
    

    if (clanHelp) {
        clanHelp.title = 
                    "<p>" +
                    "Congratulations! You joined a clan! Everything is better in a group right?<br>" +
                    "This is your clan's private page. Here you can interact with the other members of the clan. " +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "   <li>Forum: see all private posts made by other members and make your owns.</li>" +
                    "   <li>Members: see a list with all the clan members.</li>" +
                    "   <li>LeaderBoards: list of highest rated members of the clan (with more xP).</li>" + 
                    "   <li>Leave clan: if you want to be no longer a part of the clan just click the red button.</li>" +
                    "</ul>";
    }

    if (clanSettingsHelp) {
        clanSettingsHelp.title = 
                    "<p>" +
                    "As the owner of the clan you are in charge of doing its management (settings and members)." +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "   <li>General: Edit clan attributes as Name, Bio and Image.</li>" +
                    "   <li>Manager Users: Ban/Unban a member of the clan, add users to the clan or delete the clan.</li>" +
                    "</ul>";
    }

    if (clanFeedHelp) {
        clanFeedHelp.title = 
                    "<p>" +
                    "Welcome to your clan feed! Here you can:" +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "<li>Post something to be seen by the clan</li>" +
                    "<li>See all clan posts</li>" +
                    "</ul>";
    }
    
    if (leaderBoardsHelp) {
        leaderBoardsHelp.title = 
                    "<p>" +
                    "Welcome to the Honor room of AlterEgo! " +
                    "Here you can see the most legendary characters of the game." +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "   <li>Global: Podium with 3 most rated users of the website.</li>" +
                    "   <li>Clans: Podium with 3 most rated clans of the website.</i>" +
                    "   <li>Friends: Podium with your 3 most rated friends.</i>" +
                    "</ul>";
    }
  
    if (profileHelp) {
        profileHelp.title =
                    "<p>" +
                    "Right now you are in your personal page. " +
                    "Here you can find all the relevant information about you." +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "   <li>Name, Birthdate</li>" +
                    "   <li>Race, Class</li>" +
                    "   <li>Clan: if joined any</li>" +
                    "   <li>Level: ammount of xP</li>" +
                    "   <li>Activity: posts created and shared by you</li>" +
                    "   <li>Friends list</li>" +
                    "</ul>";
    }

    if (profileFeedHelp) {
        profileFeedHelp.title = 
                    "<p>" +
                    "Welcome to your own feed! Here you can:" +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "<li>Post something with text and/or image</li>" +
                    "<li>See your previous posts (created or shared)</li>" +
                    "<li>Send/Receive messages to/from your friends (right chat sidebar)</li>" +
                    "</ul>";
    }

    if (postHelp) {
        postHelp.title =
                    "<p>" +
                    "This is a post page. Here you can see the post overview:" +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "<li>Owner of the post</li>" + 
                    "<li>Content: post's text and/or image</li>" +
                    "<li>Likes, Comments and Shares</li>" +
                    "</ul>" +
                    "<br>" +
                    "<p>" +
                    "Now that you have seen the complete post don't be affraid of showing your feedback:" +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "<li>Liking it</li>" +
                    "<li>Commenting it</li>" +
                    "<li>Sharing it</li>" +
                    "</ul>";
    }

    if (chatHelp) {
        chatHelp.title = 
                    "<p>" +
                    "Don't live this experience alone! Talk with the other AlterEgo members! " +
                    "All you have to do is:" +
                    "</p>" +
                    "<ul class='list-group text-left pl-3'>" +
                    "<li>Select one of your friends to chat with (in the left list)</li>" +
                    "<li>Write the message to send (in the textbox below)</li>" +
                    "<li>" +
                    "<a><i class='far fa-envelope'></i></a> Click to send!" +
                    "</li>" +
                    "</ul>";
    }

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

function sendDeletePostRequest(e) {
    console.log("Post delete request");

    let post_id = this.closest('div.postModal').getAttribute('data-id');

    if (post_id == null)
        return;

    sendAjaxRequest('delete', '/api/post/' + post_id, null, deletedPostHandler);
}

function sendDeleteShareRequest(e) {
    console.log("Share delete request");
    
    let share_id = this.closest('div.sharedPostModal').getAttribute('data-id');

    if (share_id == null)
        return;

    sendAjaxRequest('delete', '/api/share/' + share_id, null, deletedShareHandler);
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
    let friend_id = document.querySelector('.friend-chat').getAttribute('data-id');

    if (input != "")
        sendAjaxRequest('put', '/api/chat/' + friend_id, { message: input }, addedMessageHandler);
}

function updateChatRequest(e) {
    e.preventDefault();
    console.log("Update chat request");
    let clicked = e.target.closest("a.friend-list");
    let current = document.querySelector('a.friend-list.active');
    let friend_id = clicked.getAttribute('data-id');

    current.classList.remove('active');
    clicked.classList.add('active');

    sendAjaxRequest('post', '/api/update_chat/' + friend_id, null, updatedChatHandler);
}

function setBanModalID(e) {
    e.preventDefault();

    let id = e.target.closest('button.ban_member').getAttribute('id');
    let modal = document.querySelector('.ban_modal');
    modal.disabled = false;

    modal.setAttribute('id', id);

    let modal_error = document.querySelector('#banModal .modal-body .error-msg');
    modal_error.innerHTML = "&nbsp";

    let banMember = document.querySelector('.ban_modal');
    banMember.addEventListener('click', sendBanMemberRequest);
}

function setUserBanModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-ban-modal');
    modalSubmit.setAttribute('data-id', e.target.closest('button.ban_user').getAttribute('data-id'));
    modalSubmit.disabled = false;

    let modal_msg = document.querySelector('#banModal .modal-body .msg-response');
    modal_msg.innerHTML = "&nbsp";
    
    modalSubmit.addEventListener('click', sendBanUserRequest);
}

function adminReportDismissRequest (e){
    e.preventDefault();

    let id = e.target.closest('button.dismiss').getAttribute('data-id');
    
    sendAjaxRequest('delete', '/api/deleteReport/' + id, null, dismissReportHandler);
}

function setUserUnbanModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-unban-modal');
    modalSubmit.setAttribute('data-id', e.target.closest('button.unban_user').getAttribute('data-id'));
    modalSubmit.disabled = false;

    document.querySelector('#unbanModal>div>div>div.modal-body>p>small.end-date').innerHTML = e.target.closest('button.unban_user').getAttribute('value');

    modalSubmit.addEventListener('click', sendUnbanUserRequest);
}

function setClanBanModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-ban-clan-modal');
    modalSubmit.setAttribute('data-id', e.target.closest('button.ban_clan').getAttribute('data-id'));
    modalSubmit.disabled = false;

    let modal_msg = document.querySelector('#clanBanModal .modal-body .msg-response');
    modal_msg.innerHTML = "&nbsp";

    modalSubmit.addEventListener('click', sendBanClanRequest);
}

function setClanUnbanModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-unban-clan-modal');
    modalSubmit.setAttribute('data-id', e.target.closest('button.unban_clan').getAttribute('data-id'));
    modalSubmit.disabled = false;

    document.querySelector('#clanUnbanModal>div>div>div.modal-body>p>small.end-date').innerHTML = e.target.closest('button.unban_clan').getAttribute('value');

    modalSubmit.addEventListener('click', sendUnbanClanRequest);
}

function setRmPermissionsModalID(e) {
    e.preventDefault();

    let modalSubmit = document.querySelector('.btn-rm-permissions-modal');
    modalSubmit.setAttribute('data-id', e.target.closest('button.rm_permissions').getAttribute('data-id'));
    modalSubmit.disabled = false;

    modalSubmit.addEventListener('click', sendRmPermissionsRequest);
}

function sendBanUserRequest(e) {
    e.preventDefault();
    let userID = e.target.closest('button.btn-ban-modal').getAttribute('data-id');
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

    if (selectedDuration != -1) {
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + selectedDuration);
        let date = endDate.toISOString().replace('Z', '').replace('T', ' ');
        formattedDate = date.substr(0, date.lastIndexOf('.'))
    }

    sendAjaxRequest('put', '/api/banUser/' + userID, { motive: checkedMotive, endDate: formattedDate }, banUserHandler);
}

function sendUnbanUserRequest(e) {
    e.preventDefault();
    let userID = e.target.closest('button.btn-unban-modal').getAttribute('data-id');

    sendAjaxRequest('delete', '/api/unbanUser/' + userID, null, unbanUserHandler);
}

function sendBanClanRequest(e) {
    e.preventDefault();
    let clanID = e.target.closest('button.btn-ban-clan-modal').getAttribute('data-id');

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

    if (selectedDuration != -1) {
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + selectedDuration);
        let date = endDate.toISOString().replace('Z', '').replace('T', ' ');
        formattedDate = date.substr(0, date.lastIndexOf('.'))
    }

    sendAjaxRequest('put', '/api/banClan/' + clanID, { motive: checkedMotive, endDate: formattedDate }, banClanHandler);
}

function sendUnbanClanRequest(e) {
    e.preventDefault();
    let clanID = e.target.closest('button.btn-unban-clan-modal').getAttribute('data-id');

    sendAjaxRequest('delete', '/api/unbanClan/' + clanID, null, unbanClanHandler);
}

function sendRmPermissionsRequest(e) {
    e.preventDefault();
    let userID = e.target.closest('button.btn-rm-permissions-modal').getAttribute('data-id');

    sendAjaxRequest('delete', '/api/removePermissions/' + userID, null, removePermissionsHandler);
}

function sendAddAdminPermissionsRequest(e) {
    e.preventDefault();

    let checks = document.querySelectorAll('li.invite-list-user input.checks');

    let invited_users = [];
    let invited_count = 0;

    for (let i = 0; i < checks.length; i++) {
        if (checks[i].checked) {
            invited_users.push(checks[i].closest('li.invite-list-user').getAttribute('data-id'));
            invited_count++;
        }
    }
    if (invited_count == 0) {
        return;
    }
    
    sendAjaxRequest('put', '/api/addPermissions', { invites: invited_users }, addPermissionsHandler);
}

function sendBanMemberRequest(e) {
    e.preventDefault();

    let member_id = e.target.closest('button.ban_modal').getAttribute('id');
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

    if (selectedDuration != -1) {
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + selectedDuration);

        let date = endDate.toISOString().replace('Z', '').replace('T', ' ');
        formattedDate = date.substr(0, date.lastIndexOf('.'));
    }

    sendAjaxRequest('put', '/api/banMember/' + member_id, { motive: checkedMotive, endDate: formattedDate }, banMemberHandler);
}

function sendUnBanMemberRequest(e) {
    e.preventDefault();

    let blocked_id = e.target.closest('button.unban_member').getAttribute('id');
    let clan_id = document.querySelector('.settings').getAttribute('data-id');

    sendAjaxRequest('put', '/api/unbanMember/' + blocked_id + '+' + clan_id, null, unbanMemberHandler);
}

function addInviteRequest(e) {
    e.preventDefault();

    let users = document.querySelectorAll('.invite-list-user input.checks');
    let clan_id = parseInt(document.querySelector('.invite-list').getAttribute('data-id'));

    let invited_users = [];
    let invited_count = 0;

    for (let i = 0; i < users.length; i++) {
        if (users[i].checked) {
            invited_users.push(users[i].closest('li.invite-list-user').getAttribute('data-id'));
            invited_count++;
        }
    }

    if (invited_count == 0) {
        return;
    }
    console.log(invited_users);

    sendAjaxRequest('post', '/api/inviteUsers/' + clan_id, { invites: invited_users }, addedInvitesHandler);

}

function seeMorePostsRequest(e) {
    console.log(e.target);

    let current_page = parseInt(document.querySelector('section#posts').getAttribute('data-count'));

    console.log(current_page);

    sendAjaxRequest('get', '/api/seeMoreHome/' + current_page, null, addedMoreHomeHandler);

}

function removeFriendShipRequest(e) {
    console.log('remove');
    let friend_id = parseInt(e.target.closest('.friend-remove').getAttribute('data-id'));

    sendAjaxRequest('delete', '/api/removeFriend/' + friend_id, null, removedFriendHandler);
}

function sendFriendShipRequest(e) {
    console.log('send');
    let friend_id = parseInt(e.target.closest('.friend-add').getAttribute('data-id'));

    sendAjaxRequest('put', '/api/sendFriend/' + friend_id, null, sentFriendHandler);
}

function cancelFriendShipRequest(e) {
    console.log('cancel');
    let friend_id = parseInt(e.target.closest('.friend-cancel').getAttribute('data-id'));

    sendAjaxRequest('delete', '/api/cancelFriend/' + friend_id, null, cancelledFriendHandler);
}

function answerFriendShipRequest(e) {
    console.log('answer');

    let friend_id = 0;
    let accepted = 0;

    if (e.target.closest('.friend-decline') == null) {
        friend_id = parseInt(e.target.closest('.friend-accept').getAttribute('data-id'));
        accepted = 1;
    }
    else {
        friend_id = parseInt(e.target.closest('.friend-decline').getAttribute('data-id'));
    }

    let notNumber = document.querySelector('#friendsNot>button>span');
    notNumber.innerHTML = (parseInt(notNumber.innerHTML) - 1);

    sendAjaxRequest('put', '/api/answerFriend/' + friend_id + '+' + accepted, null, answeredFriendHandler);
}

function cancelFriendShipRPRequest(e) {
    console.log('cancel2');

    let friend_id = parseInt(e.target.closest('.friend-cancel').getAttribute('data-id'));
    
    let notNumber = document.querySelector('#friendsNot>button>span');
    notNumber.innerHTML = (parseInt(notNumber.innerHTML) - 1);

    sendAjaxRequest('delete', '/api/cancelFriend/' + friend_id, null, cancelledFriendRPHandler);
}

function answerFriendShipRPRequest(e) {
    console.log('answer2');

    let friend_id = 0;
    let accepted = 0;

    if (e.target.closest('.friend-decline') == null) {
        friend_id = parseInt(e.target.closest('.friend-accept').getAttribute('data-id'));
        accepted = 1;
    }
    else {
        friend_id = parseInt(e.target.closest('.friend-decline').getAttribute('data-id'));
    }

    let notNumber = document.querySelector('#friendsNot>button>span');
    notNumber.innerHTML = (parseInt(notNumber.innerHTML) - 1);

    sendAjaxRequest('put', '/api/answerFriend/' + friend_id + '+' + accepted, null, answeredFriendRPHandler);
}

function answerClanRPRequest(e) {

    let clan_id = 0;
    let accepted = 0;

    if (e.target.closest('.clan-decline') == null) {
        clan_id = parseInt(e.target.closest('.clan-accept').getAttribute('data-id'));
        accepted = 1;
    }
    else {
        clan_id = parseInt(e.target.closest('.clan-decline').getAttribute('data-id'));
    }

    sendAjaxRequest('put', '/api/answerClan/' + clan_id + '+' + accepted, null, answeredClanRPHandler);
}

function reportPostRequest(e){
    console.log('reported');

    let post_id = e.target.closest('.reportModal').getAttribute('data-id');

    
    let motives = document.querySelectorAll('.reportModal .form-check-input');
    let checkedMotive = "";
    //get checked motive
    for (let i = 0; i < motives.length; i++) {
        if (motives[i].checked) {
            checkedMotive = motives[i].value;
            break;
        }
    }

    sendAjaxRequest('post', '/api/report/' + post_id, { motive: checkedMotive}, reportedHandler);
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

function deletedPostHandler() {
    console.log("Post deleted - status: " + this.status);

    if (this.status == 200) {
        let post = JSON.parse(this.responseText);

        let postHTML = document.querySelector('div.post[data-id="' + post.id + '"]');
        postHTML.innerHTML = '';
    }

    if (window.location.href.includes("post"))
        window.location.href = '../home';
}

function deletedShareHandler() {
    console.log("Share deleted - status: " + this.status);
    let reply = JSON.parse(this.responseText);
    console.log(reply);
    if (this.status == 200) {
        let share = JSON.parse(this.responseText);

        let shareHTML = document.querySelector('div.share[data-id="' + share.post_id + "-" + share.user_id + '"]');
        shareHTML.innerHTML = '';
    }

    if (window.location.href.includes("share"))
        window.location.href = '../home';
}

function deletedCommentHandler() {
    console.log("Comment deleted - status: " + this.status);

    if (this.status == 200) {
        let comment = JSON.parse(this.responseText);

        let commentHTML = document.querySelector('div.comment[id="' + comment.id + '"]');
        commentHTML.outerHTML = '';
    }
}

function userNotificationsHandler() {
    let response = JSON.parse(this.responseText);
    let notificationsArea = document.querySelector('#notifications > .dropdown-menu');
    console.log(response);
    notificationsArea.innerHTML = "";

    if (response.length == 0) {
        notificationsArea.innerHTML += "You have 0 notifications!";
        return;
    }

    response.forEach(element => {
        switch(element.type) {
            case 'COMMENT':
                notificationsArea.innerHTML += '<div class="no-hover notification-seen index-nav dropdown-item dropdown-navbar" type="comment" data-id="' + element.id + '"  href="/post/' + element.post_id + '#' + element.comment_id + '"> <div class="text-left">' + element.user_name + ' commented your post.</div> </div>';
            break;
            case 'LIKE':
                notificationsArea.innerHTML += '<a class="no-hover notification-seen index-nav dropdown-item dropdown-navbar" type="like" data-id="' + element.id + '" href="/post/' + element.post_id + '"> <div class="text-left">' + element.user_name + ' liked your post.</div> </a>';
            break;
            case 'SHARE':
                notificationsArea.innerHTML += '<a class="no-hover notification-seen index-nav dropdown-item dropdown-navbar" type="share" data-id="' + element.id + '" href="/share/' + element.post_id + '_' + element.user_id + '"> <div class="text-left">' + element.user_name + ' shared your post.</div> </a>';
            break;
        }
    });

    //document.querySelector('#notifications>button').innerHTML = '<i class="far fa-bell"></i> (<span>0</span>)';
    let notificationClick = notificationsArea.querySelectorAll('.notification-seen');
    [].forEach.call(notificationClick, function (notif) {
        notif.addEventListener('click', sendSeenNotification);
    });
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
            '<div class="d-flex align-items-center comment my-2" id="' + comment.id + '">'
            + '<span class="comment-avatar float-left mr-2">'
                + '<a href="/user/' + comment.username + '">'
                    + '<img class="img-fluid border rounded-circle" src="' + path_header + '/avatars/' + comment.race + '_' + comment.class + '_' + comment.gender + '.bmp" alt="Avatar">'
                + '</a>'
            + '</span>'
            + '<div class="w-90 comment-data pl-1 pr-0">'
                + '<p class="border pt-3">' + comment.comment_text + '</p>'
            + '</div>'
            + '<span class="ml-2 delete-comment" id="' + comment.id + '">'
                + '<a><i class="fas fa-times"></i></a>'
            + '</span>'
          + '</div>';

    comment_area.innerHTML += current_comms;

    let deleteComment = document.querySelectorAll('.delete-comment>a>i');
    [].forEach.call(deleteComment, function (delCom) {
        delCom.addEventListener('click', sendDeleteCommentRequest);
    });
}

function addedMessageHandler() {

    let message = JSON.parse(this.responseText);
    console.log(message);
    let message_area = document.getElementById('chatScroll');
    message_area.innerHTML += getChatMessage(true, null, message.message_text, message.date.substring(0, 10), message.date.substring(11, 19));
    message_area.scrollTop = message_area.scrollHeight;
}

function updatedChatHandler() {

    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let friend_id = document.querySelector('.friend-chat');
    let friend_names = document.querySelector('.friend-chat a');
    let friend_img = document.querySelector('.friend-chat img');

    let path = friend_img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    friend_id.setAttribute('data-id', reply.friend_info.id);
    friend_names.setAttribute('href', '/user/' + reply.friend_info.username);
    friend_names.innerHTML = reply.friend_info.name;
    friend_img.setAttribute('src', path_header + '/avatars/' + reply.friend_info.race + "_" + reply.friend_info.class + '_' + reply.friend_info.gender + '.bmp');

    let message_area = document.getElementById('chatScroll');
    message_area.innerHTML = "";

    for (let i = 0; i < reply.messages.length; i++) {
        message_area.innerHTML += getChatMessage(reply.friend_info.id == reply.messages[i].receiver, reply.friend_info, reply.messages[i].message_text, reply.messages[i].date.substring(0, 10), reply.messages[i].date.substring(11, 19));
    }

    message_area.scrollTop = message_area.scrollHeight;
}

function getChatMessage(isOutgoing, friend_info, text, date1, date2) {
    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));
    
    if(isOutgoing)
        return '<div class="my-3 outgoing_msg">'
                + '<div class="sent_msg w-50 text-right mr-2">'
                    + '<p>' + text + '</p>'
                    + '<span class="text-right mt-0 pt-0 time_date">' + date1
                        + '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + date2
                        + '&nbsp&nbsp'
                    + '</span>'
                + '</div>'
            + '</div>';
    else 
        return '<div class="my-3 incoming_msg">'
                + '<div class="incoming_msg_img">'
                     + '<img src="' + path_header + '/avatars/' + friend_info.race + '_' + friend_info.class + '_' + friend_info.gender + '.bmp" alt="logo" width="25" class="ml-2 border img-fluid rounded-circle">'
                + '</div>'
                + '<div class="received_msg">'
                    + '<div class="received_withd_msg">'
                        + '<p>' + text + '</p>'
                        + '<span class="mt-0 pt-0 time_date">' + date1
                            + '&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp' + date2
                            + '&nbsp&nbsp'
                        + '</span>'
                    + '</div>'
                + '</div>'
            + '</div>';
}

addEventListeners();
addHelpDeskText();
// ---------------------------------------------------------------------------------------------------------------------//

function sendSeenNotification(e) {
    let id = e.target.closest('.notification-seen').getAttribute('data-id');
    sendAjaxRequest('post', '/api/notificationSeen/' + id, null, seenNotificationHandler);
}

function seenNotificationHandler() {
    let reply = JSON.parse(this.responseText);

console.log(reply);
}

let lastSearch = "";

function updateFriendList($userID) {
    let currentSearch = document.querySelector('#friends>div>.searchbar>input').value;
    if (lastSearch == currentSearch)
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
function getLeaderboardSearchInfo() {
    let currentSearch = document.querySelector('#leaderboard-content>.active .leaderboard_search>input').value;
    if (lastSearch == currentSearch)
        return false;

    lastSearch = currentSearch;
    return true;
}

function updateSearchGlobal() {
    if (getLeaderboardSearchInfo())
        sendAjaxRequest('post', '/api/getLeaderboardGlobalSearch/', { search: lastSearch }, updateLeaderboardSearch);
}

function updateSearchClan() {
    if (getLeaderboardSearchInfo())
        sendAjaxRequest('post', '/api/getLeaderboardClanSearch/', { search: lastSearch }, updateClansLeaderboardSearch);
}

function updateSearchFriends() {
    if (getLeaderboardSearchInfo())
        sendAjaxRequest('post', '/api/getLeaderboardFriendsSearch/', { search: lastSearch }, updateLeaderboardSearch);
}

function updateClansLeaderboardSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);
    let list = document.querySelector('#leaderboard-content>.active ol.list');

    list.innerHTML = "";

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));
    console.log(path_header);

    reply.forEach(function (element) {
        list.innerHTML +=
            '<button type="button" class="text-left list-group-item border-0 list-group-item-action">' +
            '<li class="ml-3">' +
            '<div class="d-flex align-items-center row">' +
            '<div class="col-2 col-sm-1 friend-img">' +
            '<img width="200" class="img-fluid border rounded-circle" src="' + path_header + '/logo.png" alt="Clan">' +
            '</div>' +
            '<div class="col-7 col-sm-6 text-left">' + element.name + '</div>' +
            '</div>' +
            '</li>' +
            '</button>';
    });
}

function updateLeaderboardSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);
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

    let friendList = document.querySelectorAll('#leaderboard-content>div.to_link ol>button');
    [].forEach.call(friendList, function (friend) {
        friend.addEventListener('click', function () {
            window.location.href = this.getAttribute('data-id');
        });
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
    if (active_banned) active_list.removeChild(active_banned);

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    if(banned_list) banned_list.insertAdjacentHTML("afterbegin", getUnbanUserHTML(reply.user, reply.blocked.date, path_header));

    let reported = document.querySelectorAll('button.ban_user[data-id="' + reply.blocked.user_id + '"]');
    if(reported) reported.forEach( (element) => element.outerHTML = '<button type="button" class="ban_user btn btn-danger btn-sm" data-id="' + reply.blocked.user_id + '" disabled><i class="fas fa-user-times"></i> User Already Banned</button>');

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

    if (unbanned == null) return; // error occurred

    banned_list.removeChild(unbanned);

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let userID = img.getAttribute('data-id');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    active_list.insertAdjacentHTML("afterbegin", getActiveUserHTML(reply.user, path_header, userID));

    let reported = document.querySelectorAll('#v-pills-reports button.ban_user[data-id="' + reply.user.id + '"]');
    [].forEach.call(reported, function (element) {
        element.outerHTML = '<button type="button" class="ban_user btn btn-danger btn-sm" data-id="' + reply.user.id + '" data-toggle="modal" data-target="#banModal"><i class="fas fa-user-times"></i> Ban User</button>';
    });

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

    if (active_banned == null) return; // error occurred

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

    if (unbanned == null) return; // error occurred

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

    if (removed == null) return; // error occurred
    active_admins.removeChild(removed);
}

function dismissReportHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let entry = document.querySelector('li[data-id="report' + reply.id + '"]');
    entry.parentElement.removeChild(entry);
}

function addPermissionsHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let invited_users = reply.invited;
    let active_admins = document.querySelector('ul.admins-active');
    let not_admins = document.querySelector('ul.not-admin-users');

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let userID = img.getAttribute('data-id');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    for (let i = 0; i < invited_users.length; i++) {
        let invited = not_admins.querySelector('li.invite-list-user[data-id="' + invited_users[i].id + '"]');
        not_admins.removeChild(invited);
        active_admins.insertAdjacentHTML("afterbegin", getActiveAdminPermissionsHTML(invited_users[i], path_header, userID));
    }

    let adminRmPermissionsModal = document.querySelectorAll('.rm_permissions');
    [].forEach.call(adminRmPermissionsModal, function (admin) {
        admin.addEventListener('click', setRmPermissionsModalID);
    });
}

function banMemberHandler() {

    let reply = JSON.parse(this.responseText);
    let banned = reply.banned;

    let modal_msg = document.querySelector('#banModal .modal-body .error-msg');
    modal_msg.innerHTML = "Member banned!";
    let banButton = document.querySelector('#banModal .modal-body .ban_modal');
    banButton.disabled = true;

    let active_list = document.querySelector('ul.active'); //list of active members
    let banned_list = document.querySelector('ul.banned'); //list of banned members
    let msg = document.querySelector('h5.no-banned'); if (msg) msg.outerHTML = "";
    let active_banned = document.querySelector('ul.active [data-id="' + banned.id + '"]'); //member in active list that was banned

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    active_list.removeChild(active_banned);

    banned_list.insertAdjacentHTML("afterbegin", '<li class="p-2 ml-3" data-id="' + banned.id + '">' +
        '<div class="d-flex align-items-center row">' +
        '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">' +
        '<img width="40" class="border bg-warning img-fluid rounded-circle border"' +
        'src="' + path_header + '/avatars/' + banned.race + '_' + banned.class + '_' + banned.gender + '.bmp" alt="Clan">' +
        '</div>' +
        '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="/user/' + banned.username + '">' + banned.name + '</a></div>' +
        '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">' +
        '<button type="button" class="unban_member btn btn-success btn-sm" data-id="' + banned.id + '">' +
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

function unbanMemberHandler() {

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

    active_list.insertAdjacentHTML("afterbegin", '<li class="p-2 ml-3" data-id="' + unbanned.id + '">' +
        '<div class="d-flex align-items-center row">' +
        '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">' +
        '<img width="40" class="border bg-warning img-fluid rounded-circle border"' +
        'src="' + path_header + '/avatars/' + unbanned.race + '_' + unbanned.class + '_' + unbanned.gender + '.bmp" alt="Clan">' +
        '</div>' +
        '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="/user/' + unbanned.username + '">' + unbanned.name + '</a></div>' +
        '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">' +
        '<button type="button" class="ban_member btn btn-danger btn-sm" id="' + unbanned.id + '" data-toggle="modal" data-target="#banModal">' +
        '<i class="fas fa-user-times"></i> Ban Member' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</li>');


    let openBanModal = document.querySelectorAll('.ban_member');
    [].forEach.call(openBanModal, function (member) {
        member.addEventListener('click', setBanModalID);
    });
}
// ---------------------------------------------------------------------------------------------------------------------//

function clanMembersSearch($clanID) {
    let currentSearch = document.querySelector('#members.active>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
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

function clanLeaderboardSearch($userID) {
    let currentSearch = document.querySelector('#leaderboard.active>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getClanSearch/' + $userID, { search: lastSearch }, updateClanUsersLeaderboardSearch);
}

function updateClanUsersLeaderboardSearch() {
    let reply = JSON.parse(this.responseText);

    let list = document.querySelector('#leaderboard.active>ol');
    list.innerHTML = "";

    let img = document.querySelector('img.img-fluid');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function (element) {
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

    let friendList = document.querySelectorAll('#leaderboard>ol>button');
    [].forEach.call(friendList, function (friend) {
        friend.addEventListener('click', function () {
            window.location.href = this.getAttribute('data-id');
        });
    });
}

// ---------------------------------------------------------------------------------------------------------------------//

function userListHandler(reply, list, path_header) {

    reply.forEach(function (element) {

        list.innerHTML +=
            '<li class="list-group shadow-lg">'
            + '<button data-id="/user/' + element.username + '" type="button" class="text-left list-group-item list-group-item-action">'
            + '<div class="d-flex align-items-center row">'
            + '<div class="col-2 col-sm-1 friend-img">'
            + '<img src="' + path_header + '/avatars/'
            + element.race + '_' + element.class + '_' + element.gender + '.bmp"' + 'alt=logo'
            + ' class="border bg-light img-fluid rounded-circle">'
            + '</div>'
            + '<div class="col-5 col-sm-6 pr-1">' + element.name + '</div>'
            //+               '<div class="col-5 col-sm-5 pl-1 text-right">' + element.date + '</div>'
            + '</div>'
            + '</button>'
            + '</li>';
    });

    let friendList = document.querySelectorAll('#friends>ul>li>button, #members>ul>li>button');
    [].forEach.call(friendList, function (friend) {
        friend.addEventListener('click', function () {
            window.location.href = this.getAttribute('data-id');
        });
    });
}

function addedInvitesHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let invited_users = reply.invited.split(',');

    let invite_list = document.querySelector('.invite-list');

    for (let i = 0; i < invited_users.length; i++) {
        console.log(invited_users[i]);
        let invited = document.querySelector('.invite-list-user[data-id="' + parseInt(invited_users[i]) + '"]');
        console.log(invited);
        invite_list.removeChild(invited);
    }
}

// ---------------------------------------------------------------------------------------------------------------------//

function searchActiveClanUsers($clanID) {
    let currentSearch = document.querySelector('#active>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getActiveClanUsersSearch/' + $clanID, { search: lastSearch }, updateActiveClanUsersSearch);
}

function searchBannedClanUsers(clanID) {
    let currentSearch = document.querySelector('#banned>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getBannedClanUsersSearch/' + clanID, { search: lastSearch }, updateBannedClanUsersSearch);
}

function activeUsersSearch() {
    let currentSearch = document.querySelector('#active>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getActiveUsersSearch', { search: lastSearch }, updateActiveUsersSearch);
}

function bannedUsersSearch() {
    let currentSearch = document.querySelector('#banned>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getBannedUsersSearch', { search: lastSearch }, updateBannedUsersSearch);
}

function updateActiveClanUsersSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    $users = document.querySelector('#active ul.active');

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    $users.innerHTML = "";

    reply.users.forEach(function (element) {

        let button = "";
        if (parseInt(reply.userID) == element.id)
            button = '<button type="button" class="btn btn-danger btn-sm" disabled>';
        else
            button = '<button type="button" class="ban_member btn btn-danger btn-sm" data-id="' + element.id + '" data-toggle="modal" data-target="#banModal">';

        $users.innerHTML += '<li class="p-2 ml-3" data-id="' + element.id + '">' +
            '<div class="d-flex align-items-center row">' +
            '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">' +
            '<img width="40" class="border bg-warning img-fluid rounded-circle border"' +
            'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp" alt="Clan">' +
            '</div>' +
            '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="/user/' + element.username + '">' + element.name + '</a></div>' +
            '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">' +
            button +
            '<i class="fas fa-user-times"></i> Ban Member' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</li>';
    });

    let openBanModal = document.querySelectorAll('.ban_member');
    [].forEach.call(openBanModal, function (member) {
        member.addEventListener('click', setBanModalID);
    });
}

function updateBannedClanUsersSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);


    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    $users = document.querySelector('#banned ul.banned');
    $users.innerHTML = "";

    reply.forEach(function (element) {
        $users.innerHTML += '<li class="p-2 ml-3" data-id="' + element.id + '">' +
            '<div class="d-flex align-items-center row">' +
            '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">' +
            '<img width="40" class="border bg-warning img-fluid rounded-circle border"' +
            'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp" alt="Clan">' +
            '</div>' +
            '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="/user/' + element.username + '">' + element.name + '</a></div>' +
            '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">' +
            '<button type="button" class="unban_member btn btn-success btn-sm" data-id="' + element.id + '">' +
            '<i class="fas fa-user-times"></i> Unban Member' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</li>';
    });

    let unbanMember = document.querySelectorAll('.unban_member');
    [].forEach.call(unbanMember, function (blocked) {
        blocked.addEventListener('click', sendUnBanMemberRequest);
    });
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

    reply.forEach(function (element) {
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

    let usersList = document.querySelector('#users-content>div.active>ul');
    usersList.innerHTML = "";

    let path = document.querySelector('#nav-user-img').getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    for(let i = 0; i < reply.users.length; i++) {
        usersList.innerHTML += getUnbanUserHTML(reply.users[i], reply.dates[i], path_header);
    }

    let adminUnbanUsersModal = document.querySelectorAll('.unban_user');
    [].forEach.call(adminUnbanUsersModal, function (user) {
        user.addEventListener('click', setUserUnbanModalID);
    });
}

function getActiveUserHTML(element, path_header, userID) {
    let button = "";
    if (element.id == userID) button = '<button type="button" class="btn btn-danger btn-sm" disabled>';
    else button = '<button type="button" class="ban_user btn btn-danger btn-sm" data-id="' + element.id + '" data-toggle="modal" data-target="#banModal">'

    return '<li class="p-2 ml-4" data-id="' + element.id + '">'
        + '<div class="d-flex align-items-center row">'
        + '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        + '<img width="50" class="border img-fluid rounded-circle" alt="Clan"'
        + 'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
        + '</div>'
        + '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="user/' + element.username + '">' + element.name + '</a></div>'
        + '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
        + button
        + '<i class="fas fa-user-times"></i> Ban User'
        + '</button>'
        + '</div>'
        + '</div>'
        + '</li>';
}

function getUnbanUserHTML(element, date, path_header) {
    return '<li class="p-2 ml-4" data-id="' + element.id + '">'
        + '<div class="d-flex align-items-center row">'
        + '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        + '<img width="50" class="border img-fluid rounded-circle" alt="Clan"'
        + 'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
        + '</div>'
        + '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="user/' + element.username + '">' + element.name + '</a></div>'
        + '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
        + '<button type="button" class="unban_user btn btn-success btn-sm" data-id="' + element.id + '" value="' + date + '" data-toggle="modal" data-target="#unbanModal">'
        + '<i class="fas fa-user-times"></i> Unban User'
        + '</button>'
        + '</div>'
        + '</div>'
        + '</li>';
}

// ---------------------------------------------------------------------------------------------------------------------//

function activeClansSearch() {
    let currentSearch = document.querySelector('#active-clans>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getActiveClansSearch', { search: lastSearch }, updateActiveClansSearch);
}

function bannedClansSearch() {
    let currentSearch = document.querySelector('#banned-clans>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getBannedClansSearch', { search: lastSearch }, updateBannedsClansSearch);
}

function updateActiveClansSearch() {
    let reply = JSON.parse(this.responseText);

    let clans = document.querySelector('#clans-content>div.active>ul');
    clans.innerHTML = "";

    let path = document.querySelector('#nav-user-img').getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function (element) {
        clans.innerHTML += getActiveClanHTML(element, path_header);
    });
}

function getActiveClanHTML(element, path_header) {
    return '<li class="p-2 ml-3" data-id="' + element.id + '">'
        + '<div class="d-flex align-items-center row">'
        + '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        + '<img width="50" class="border img-fluid rounded-circle border" alt="Clan" src="' + path_header + '/clanImgs/' + element.id + '.jpg' + '">'
        + '</div>'
        + '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="clan/' + element.id + '">' + element.name + '</a></div>'
        + '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
        + '<button type="button" class="ban_clan btn btn-danger btn-sm" data-id="' + element.id + '" data-toggle="modal" data-target="#clanBanModal">'
        + '<i class="fas fa-user-times"></i> Ban Clan'
        + '</button>'
        + '</div>'
        + '</div>'
        + '</li>';
}

function updateBannedsClansSearch() {
    let reply = JSON.parse(this.responseText);

    let users = document.querySelector('#clans-content>div.active>ul');
    users.innerHTML = "";

    let path = document.querySelector('#nav-user-img').getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function (element) {
        users.innerHTML += getUnbanClanHTML(element, path_header);
    });

    let adminUnbanClansModal = document.querySelectorAll('.unban_clan');
    [].forEach.call(adminUnbanClansModal, function (clan) {
        clan.addEventListener('click', setClanUnbanModalID);
    });
}

function getUnbanClanHTML(element, path_header) {
    return '<li class="p-2 ml-3" data-id="' + element.id + '">'
        + '<div class="d-flex align-items-center row">'
        + '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        + '<img width="50" class="border img-fluid rounded-circle border" alt="Clan" src="' + path_header + '/clanImgs/' + element.id + '.jpg' + '">'
        + '</div>'
        + '<div class="col-6 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="clan/' + element.id + '">' + element.name + '</a></div>'
        + '<div class="col-3 col-sm-4 col-md-4 px-0 text-right">'
        + '<button type="button" class="unban_clan btn btn-success btn-sm" data-id="' + element.id + '" data-toggle="modal" data-target="#clanUnbanModal">'
        + '<i class="fas fa-user-times"></i> Unban Clan'
        + '</button>'
        + '</div>'
        + '</div>'
        + '</li>';
}

// ---------------------------------------------------------------------------------------------------------------------//

function activeAdminsSearch() {
    let currentSearch = document.querySelector('#admins-content>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getActiveAdminsSearch', { search: lastSearch }, updateActiveAdminsSearch);
}

function potentialAdminsSearch() {
    let currentSearch = document.querySelector('#addModal>div>div>div.modal-body>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getPotentialAdminsSearch', { search: lastSearch }, updatePotentialAdminsSearch);
}

function getPotentialClanUsersSearch(clanID) {
    let currentSearch = document.querySelector('#addMembersModal>div>div>div.modal-body>div>div.searchbar>input').value;
    if (lastSearch == currentSearch)
        return;
    lastSearch = currentSearch;

    sendAjaxRequest('post', '/api/getPotentialClanUsersSearch/' + clanID, { search: lastSearch }, updatePotentialClanUsersSearch);
}

function updateActiveAdminsSearch() {
    let reply = JSON.parse(this.responseText);
    console.log("searched");

    let users = document.querySelector('#v-pills-administrators>ul');
    users.innerHTML = "";

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let userID = img.getAttribute('data-id');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function (element) {
        users.innerHTML += getActiveAdminPermissionsHTML(element, path_header, userID)
    });

    let adminRmPermissionsModal = document.querySelectorAll('.rm_permissions');
    [].forEach.call(adminRmPermissionsModal, function (admin) {
        admin.addEventListener('click', setRmPermissionsModalID);
    });
}

function getActiveAdminPermissionsHTML(element, path_header, userID) {
    let button = "";
    if (element.id == userID) button = '<button type="button" class="btn btn-danger btn-sm" disabled>';
    else button = '<button type="button" class="rm_permissions btn btn-danger btn-sm" data-id="' + element.id + '" data-toggle="modal" data-target="#removePermModal">';

    return '<li class="p-2 ml-3" data-id="' + element.id + '">'
        + '<div class="d-flex align-items-center row">'
        + '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        + '<img width="50" class="border img-fluid rounded-circle border"'
        + 'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
        + '</div>'
        + '<div class="col-5 col-sm-5 col-md-6 pr-1 text-left"><a class="no-hover standard-text" href="⁄user/' + element.username + '">' + element.name + '</a></div>'
        + '<div class="col-4 col-sm-4 col-md-4 px-0 text-right">'
        + button
        + '<i class="fas fa-user-times"></i> Remove Permissions'
        + '</button>'
        + '</div>'
        + '</div>'
        + '</li>';
}

function updatePotentialAdminsSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let users = document.querySelector('#addModal>div>div>div.modal-body>ul');
    users.innerHTML = "";

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function (element) {
        users.innerHTML += getUserCheckboxHTML(element, path_header);
    });
}


function updatePotentialClanUsersSearch() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);

    let users = document.querySelector('#addMembersModal>div>div>div.modal-body>ul');
    users.innerHTML = "";

    let img = document.querySelector('#nav-user-img');
    let path = img.getAttribute('src');
    let path_header = path.substr(0, path.indexOf("/avatars/"));

    reply.forEach(function (element) {
        users.innerHTML += getUserCheckboxHTML(element, path_header);
    });
}

function getUserCheckboxHTML(element, path_header) {
    return '<li class="invite-list-user p-2 ml-3" data-id="' + element.id + '">'
        + '<div class="d-flex align-items-center row">'
        + '<div class="pl-0 col-2 col-sm-2 col-md-1 friend-img">'
        + '<img width="40" class="border img-fluid rounded-circle border" alt="User"'
        + 'src="' + path_header + '/avatars/' + element.race + '_' + element.class + '_' + element.gender + '.bmp">'
        + '</div>'
        + '<div class="col-7 col-sm-6 col-md-7 pr-1 text-left">'
        + '<a class="no-hover standard-text" href="user/' + element.username + '">' + element.name + '</a>'
        + '</div>'
        + '<div class="col-2 col-sm-3 col-md-3 px-0 text-right">'
        + '<input class="checks" name="new" type="radio">'
        + '<span class="checkmark"></span>'
        + '</div>'
        + '</div>'
        + '</li>';
}
// ---------------------------------------------------------------------------------------------------------------------//


function addedMoreHomeHandler() {
    let reply = JSON.parse(this.responseText);
    console.log(reply);
    console.log(reply.posts.current_page);
    console.log();

    let current_page = reply.posts.current_page + 1;
    document.querySelector('section#posts').setAttribute('data-count', current_page);

    let posts = reply.posts.data;
    let posts_div = document.querySelector('section#posts');

    // for(let i = 0; i < posts.length; i++){
    //     posts_div.innerHTML += 
    // }
}

function removedFriendHandler() {

    let reply = JSON.parse(this.responseText);
    let old_button = document.querySelector('.friend-remove');
    let friend = old_button.getAttribute('data-id');
    let new_button = "";

    if (reply.can_send) {
        new_button = '<button type="button" class="friend-add friend-width col-sm-12 mt-3 btn btn-outline-success" data-id="' + friend + '">'
            + 'Add as Friend <i class="fas fa-user-plus"></i>'
            + '</button>';

        old_button.outerHTML = new_button;

        let newEvent = document.querySelector('.friend-add');
        if (newEvent) newEvent.addEventListener('click', sendFriendShipRequest);
    }
    else {
        new_button = '<button type="button" class="col-sm-12 mt-3 btn btn-secondary" data-id="' + friend + '" disabled> '
            + 'Friendship blocked <i class="fas fa-user-slash"></i>'
            + '</button>';

        old_button.outerHTML = new_button;
    }

    let sidebar_chat = document.querySelector('.chat-side-bar');
    let chat_icon = document.querySelector('.chat-side-bar [data-id="' + friend + '"]');
    sidebar_chat.removeChild(chat_icon);

    let active = document.querySelector('.friend-chat');
    active.disabled = 'true';
}

function sentFriendHandler() {
    let old_button = document.querySelector('.friend-add');
    let friend = old_button.getAttribute('data-id');
    let new_button = '<button type="button" class="friend-cancel friend-width col-sm-12 mt-3 btn btn-danger" data-id="' + friend + '"> '
        + 'Cancel Request <i class="fas fa-times"></i>'
        + '</button>';

    old_button.outerHTML = new_button;

    let newEvent = document.querySelector('.friend-cancel');
    if (newEvent) newEvent.addEventListener('click', cancelFriendShipRequest);

}

function cancelledFriendHandler() {
    let old_button = document.querySelector('.friend-cancel');
    let friend = old_button.getAttribute('data-id');
    let new_button = '<button type="button" class="friend-add friend-width col-sm-12 mt-3 btn btn-outline-success" data-id="' + friend + '"> '
        + 'Add as Friend <i class="fas fa-user-plus"></i>'
        + '</button>';

    old_button.outerHTML = new_button;

    let newEvent = document.querySelector('.friend-add');
    if (newEvent) newEvent.addEventListener('click', sendFriendShipRequest);

}

function answeredFriendHandler() {
    let reply = JSON.parse(this.responseText);
    let old_button = document.querySelector('.friend-answers');
    let friend = document.querySelector('.friend-accept').getAttribute('data-id');
    let new_button = "";

    if (parseInt(reply.accepted)) {
        new_button = '<button type="button" class="friend-remove friend-width col-sm-12 mt-3 btn btn-outline-danger" data-id="' + friend + '">'
            + 'Remove Friendship <i class="fas fa-user-times"></i>'
            + '</button>';

        old_button.outerHTML = new_button;

        let newEvent = document.querySelector('.friend-remove');
        if (newEvent) newEvent.addEventListener('click', removeFriendShipRequest);

        let sidebar_chat = document.querySelector('.chat-side-bar');
        console.log(reply.friend.name);
        //     let new_friend = '<a class="friend-list list-group-item list-group-item-action" data-id="' +  +'" data-toggle="list" href="#list-{{ $user->id }}" aria-controls="{{ $user->id }}">
        //     <img src="{{ asset('assets/avatars/'.$user->race.'_'.$user->class.'_'.$user->gender.'.bmp') }}" alt="logo" width="25" class="mr-2 border bg-warning img-fluid rounded-circle">
        //     {{ $user->name }}
        // </a>

    }
    else {
        new_button = '<button type="button" class="friend-add col-sm-12 friend-width mt-3 btn btn-outline-success" data-id="' + friend + '">'
            + 'Add as Friend <i class="fas fa-user-plus"></i>'
            + '</button>';

        old_button.outerHTML = new_button;

        let newEvent = document.querySelector('.friend-add');
        if (newEvent) newEvent.addEventListener('click', sendFriendShipRequest);
    }
}

function cancelledFriendRPHandler() {
    let reply = JSON.parse(this.responseText);

    let old_div = document.querySelector('.sent-r');
    let answered = document.querySelector('.friend-cancel-rp[data-id="' + reply.friend + '"]');
    old_div.removeChild(answered);

    let count = parseInt(document.querySelector('#sent-tab span').innerHTML);
    document.querySelector('#sent-tab span').innerHTML = count - 1;

    if (count - 1 == 0) {
        let sent = document.querySelector('#sent');
        let ul = document.querySelector('#sent ul')

        sent.removeChild(ul);
        sent.innerHTML = '<p class="text-center mt-3 mb-0 standard-text">There are no sent requests!</p>';
    }
}

function answeredFriendRPHandler() {

    let reply = JSON.parse(this.responseText);

    let old_div = document.querySelector('.received-r');
    let answered = document.querySelector('.friend-answer-rp[data-id="' + reply.friend + '"]');
    old_div.removeChild(answered);

    let count = parseInt(document.querySelector('#received-tab span').innerHTML);
    document.querySelector('#received-tab span').innerHTML = count - 1;

    if (count - 1 == 0) {
        let received = document.querySelector('#received');
        let ul = document.querySelector('#received ul')

        received.removeChild(ul);
        received.innerHTML = '<p class="text-center mt-3 mb-0 standard-text">There are no received requests!</p>';
    }
}


function answeredClanRPHandler() {
    let reply = JSON.parse(this.responseText);

    let accepted = reply.accepted;
    let clan_id = reply.clan;

    if (accepted == 1) {
        window.location.href = "/clan";
    }
    else {
        let old_div = document.querySelector('.clan-received-r');
        let answered = document.querySelector('.friend-answer-rp[data-id="' + clan_id + '"]');
        old_div.removeChild(answered);
    }

    let count = parseInt(document.querySelector('#clan-received-tab span').innerHTML);
    document.querySelector('#clan-received-tab span').innerHTML = count - 1;

    if (count - 1 == 0) {
        let clan_received = document.querySelector('#clan-received');
        let ul = document.querySelector('#clan-received ul')

        clan_received.removeChild(ul);
        clan_received.innerHTML = '<p class="text-center mt-3 mb-0 standard-text">There are no clan requests!</p>';
    }
}

function reportedHandler(){
    let reply = JSON.parse(this.responseText);

    console.log(reply.has_report);

    if(reply.has_report)
        $('#report-repeated').modal('show');
    else
        $('#report-success').modal('show');
}

function getPostHTML(user, post, path_header) {
    retorno = ''
        + '<div class="modal postModal fade" id="deletePostModal-' + post.id + '" data-id="' + post.id + '" tabindex="-1" role="dialog" aria-labelledby="removePostModalLabel" aria-hidden="true">'
        + '<div class="modal-dialog" role="document">'
        + '<div class="modal-content">'
        + '<div class="modal-header">'
        + '<h5 class="modal-title" id="removePostModalLabel">Delete post</h5>'
        + '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
        + '<span aria-hidden="true">&times;</span>'
        + '</button>'
        + '</div>'
        + '<div class="modal-body">'
        + '<p class="text-left">Are you sure you want to delete this post?</p>'
        + '<div class="float-right">'
        + '<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">'
        + '<span aria-hidden="true">Yes</span>'
        + '</button>'
        + '<button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">'
        + '<span aria-hidden="true">No</span>'
        + '</button>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<div class="container post mt-4 mb-2 p-0" data-id="' + post.id + '">'
        + '<div class="cardbox text-left shadow-lg bg-white">'
        + '<div class="cardbox-heading">'
        + '<div class="dropdown float-right mt-3 mr-3">'
        + '<button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>'
        + '<div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">'
        + '<a class="dropdown-item" href="#">Report</a>'
        + '<a class="dropdown-item" data-toggle="modal" data-target="#deletePostModal-' + post.id + '">Delete</a>'
        + '</div>'
        + '</div>'
        + '<div class="media m-0">'
        + '<div class="d-flex m-3">'
        + '<a class="mx-1 my-1" href="/user/' + user.username + '">'
        + '<img class="img-fuild rounded-circle"'
        + 'src="' + path_header + '/avatars/' + user.race + '_' + user.class + '_' + user.gender + '.bmp"'
        + 'alt="User">'
        + '</a>'
        + '</div>'
        + '<div class="media-body ml-1 align-self-center">'
        + '<p class="text-dark m-0 user-link">'
        + '<a class="user-link" href="/user/' + user.username + '">' + user.name + '</a>'
        + '</p>'
        + '<small><span><i class="icon ion-md-time mt-0"></i>' + (post.date.substring(0, 19)) + '</span></small>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '<a class="box-link no-hover" href="../post/' + post.id + '">'
        + '<div class="cardbox-item mx-3">' + post.content + '</div>';

        if(post.has_img){
            retorno +=  '<div class="text-center">'
                        + '<img class="img-posts" src="assets/postImgs/' + post.id + '.png" alt="Post Image">'
                        + '</div>';
        }
        retorno += '</a>'
        + '<div class="cardbox-base text-center">'
        + '<ul class="fst mx-3 mb-1">'
        + '<li><a><i class="fa fa-thumbs-up"></i></a></li>'
        + '<li><a><span>0</span></a></li>'
        + '</ul>'
        + '<ul class="scd mx-3 mt-2">'
        + '<li><a><i class="fa fa-comments"></i></a></li>'
        + '<li><a><em class="mr-5">0</em></a></li>'
        + '<li><a data-toggle="modal" data-target="#sharePostModal-' + post.id + '"><i class="fa fa-share-alt"></i></a></li>'
        + '<li><a><em class="mr-3">0</em></a></li>'
        + '</ul>'
        + '</div>'
        + '</div>'
        + '</div>';

        return retorno;
}

function getShareHTML(share, post, user_share, user_post, user, path_header) {

    let retorno =  '<div class="modal shareModal fade" id="sharePostModal-' + share.post_id + '" data-id="' + share.post_id + '" tabindex="-1" role="dialog" aria-labelledby="removePostModalLabel" aria-hidden="true">'
                    + '<div class="modal-dialog align-center" role="document">'
                    + '<div class="modal-content">'
                    + '<div class="modal-header">'
                    + '<h5 class="modal-title" id="removePostModalLabel">Share post</h5>'
                    + '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                    + '<span aria-hidden="true">&times;</span>'
                    + '</button>'
                    + '</div>'
                    + '<div class="modal-body">'
                    + '<form method="post" action="/api/share/' + share.post_id + '">'
                    + '<textarea class="rounded border-secondary w-100" rows="4" placeholder="Write your share message..." name="content"></textarea>'
                    + '<div class="float-right">'
                    + '<button type="submit" class="btn btn-success">Share</button>'
                    + '</div>'
                    + '</form>'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    + '</div>';

    if(user.id = user_share.id || user.is_admin){
        retorno += '   <div class="modal sharedPostModal fade" id="deleteShareModal-' + share.post_id + '-' + user_share.id + '" data-id="' + share.post_id +'-' + user_share.id + '" tabindex="-1" role="dialog" aria-labelledby="removeShareModalLabel" aria-hidden="true">'
        + '<div class="modal-dialog" role="document">'
        + '<div class="modal-content">'
        + '<div class="modal-header">'
        + '<h5 class="modal-title" id="removeShareModalLabel">Delete share</h5>'
        + '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
        + '<span aria-hidden="true">&times;</span>'
        + '</button>'
        + '</div>'
        + '<div class="modal-body">'
        + '<p class="text-left">Are you sure you want to delete this share?</p>'
        + '<div class="float-right">'
        + '<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">'
        + '<span aria-hidden="true">Yes</span>'
        + '</button>'
        + '<button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">'
        + '<span aria-hidden="true">No</span>'
        + '</button>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>'
        + '</div>';
    }   

    retorno += '<div class="container post share mt-4 mb-2 p-0" data-id="' + share.post_id + '-' + user_share.id  + '">'
    + '<div class="cardbox text-left shadow-lg bg-white">'
    + '<div class="cardbox-heading">'
    + '<div class="dropdown float-right mt-3 mr-3">'
    + '<button class="btn btn-flat btn-flat-icon" type="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>'
    + '<div class="dropdown-menu dropdown-scale dropdown-menu-right" role="menu">';

  if(user_share.id == user.id || user.is_admin){
      retorno += '<a class="dropdown-item" data-toggle="modal" data-target="#deleteShareModal-' + share.post_id + '-' + user_share.id  + '">Delete</a>';
  }

  retorno += '</div>'
    + '</div>'
    + '<div class="media m-0">'
    + '<div class="d-flex m-3">'
    + '<a class="mx-1 my-1" href="/user/' + user_share.username + '">'
    + '<img class="img-fuild rounded-circle" src="assets/avatars/' + user_share.race + '_' +  user_share.class + '_' + user_share.gender + '.bmp" alt="User">'
    + '</a>'
    + '</div>'
    + '<div class="media-body ml-1 align-self-center">' 
    + '<p class="text-dark m-0 user-link">'
    + '<a class="user-link" href="/user/' + user_share.username + '">' + user_share.name + '</a> shared a post from'
    + '<a class="user-link" href="/user/' + user_post.username + '}">' + user_post.name + '</a>'
    + '</p>'
    + '<small><span><i class="icon ion-md-time mt-0"></i>' + share.date.substring(0, 19) + '</span></small>'
    + '</div>'
    + '</div>'
    + '</div>'
    + '<a class="box-link no-hover" href="/share/' + share.post_id + '_' + user_share.id + '"><div class="cardbox-item mx-3 mb-2">' +  share.content + '</div></a>'
    + getPostHTML(user_post, post, path_header)
    + '</div>'
    + '</div>';   

    return retorno;
}

function sendMorePostsRequest(e) {
    let offset = e.target.closest('div.crs').getAttribute('data-id');

    sendAjaxRequest('post', '/api/getMoreUserPosts/' + offset, null, updateUserPostsHandler);
}

function updateUserPostsHandler() {
    let reply = JSON.parse(this.responseText);

    reply = reply.sort(function(a, b){
        var keyA = new Date(a.date),
            keyB = new Date(b.date);
        // Compare the 2 dates
        if(keyA < keyB) return 1;
        if(keyA > keyB) return -1;
        return 0;
    });

    console.log(reply);

    for (var i = 0; i < reply.length; i++) 
    {
        let current = reply[i];
        let postsList = document.querySelector('#posts-list');
        let img = document.querySelector('#nav-user-img');
        let path = img.getAttribute('src');
        let path_header = path.substr(0, path.indexOf("/avatars/"));

        // if(current[0] == 'post'){ //load posts
        //     postsList.innerHTML += getPostHTML(current[2][0],current[1][0], path_header);
        // }
        // else{ //load shares
        //     postsList.innerHTML += getShareHTML(current[1][0],current[2][0], current[3][0], current[4][0], current[5], path_header);
        // }
    }
}