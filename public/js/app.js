function addEventListeners() {

    let deleteLike = document.querySelectorAll('li>a>i.fa-thumbs-up.active');
    [].forEach.call(deleteLike, function(like) {
        like.addEventListener('click', sendDeleteLikeRequest);
    });
    let addLike = document.querySelectorAll('li>a>i.fa-thumbs-up:not(.active)');
    [].forEach.call(addLike, function(like) {
        like.addEventListener('click', sendAddLikeRequest);
    });

    let friendList = document.querySelectorAll('#friends>ul>li>button, #members>ul>li>button, #leaderboard-content>div>ol>button');
    [].forEach.call(friendList, function(friend) {
        friend.addEventListener('click', function() {
            window.location.href = this.getAttribute('data-id');
        });
    });

    let addPost = document.querySelector('#postModal>div>div>div.modal-footer>button.create');
    if(addPost) addPost.addEventListener('click', sendAddPostRequest);

    let postModal = document.querySelectorAll('div.postModal>div>div>div.modal-body>div>button.btn-danger');
    [].forEach.call(postModal, function(delPost) {
        delPost.addEventListener('click', sendDeletePostRequest);
    });

    /*$("div.post").hover(function() {
        $post_id = $(this)[0].getAttribute('data-id');
        addEventListener('click', function() {
            window.location.href = "/post/" + $post_id;
        })
    });*/
}

function encodeForAjax(data) {
    if(data == null) return null;
    return Object.keys(data).map(function(k) {
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
    if(content == '') return;

    sendAjaxRequest('put', '/api/post', { content: content}, addedPostHanlder);
}

function sendDeletePostRequest(e) {
    console.log("Post delete request");

    let post_id = this.closest('div.postModal').getAttribute('data-id');
    
    if(post_id == null)
        return;

    sendAjaxRequest('delete', '/api/post/' + post_id, null, deletedPostHandler);
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

    if(this.status == 200) {
        let post = JSON.parse(this.responseText);
        
        let postHTML = document.querySelector('div.post[data-id="'+post.id+'"]');
        postHTML.innerHTML = '';
    }
}

addEventListeners();