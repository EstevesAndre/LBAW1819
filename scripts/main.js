
/*
Update Active Friend On Chat  
*/
let friends = document.getElementById('chat-friends');
let active_friend = document.getElementById('active-chat-header');
if(friends) friends.addEventListener('click', updateActiveChat);

function updateActiveChat(e) {
    active_friend.innerHTML = e.target.innerHTML;
}