function addEventListeners() {

    let deleteLike = document.querySelectorAll('li>a>i.fa-thumbs-up.active');
    [].forEach.call(deleteLike, function(like) {
        like.addEventListener('click', sendDeleteLikeRequest);
    });
    let addLike = document.querySelectorAll('li>a>i.fa-thumbs-up:not(.active)');
    [].forEach.call(addLike, function(like) {
        like.addEventListener('click', sendAddLikeRequest);
    });
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
    console.log("delete");
    let post_id = this.closest('div.post').getAttribute('data-id');

    sendAjaxRequest('delete', '/api/like/' + post_id, null, deletedLikeHandler);
}

function sendAddLikeRequest(event) {
    console.log("add");

    let post_id = this.closest('div.post').getAttribute('data-id');

    sendAjaxRequest('put', '/api/like/' + post_id, null, addedLikeHandler);

    event.preventDefault();
}

// Handlers
function deletedLikeHandler() {
    console.log("delete2");
    console.log(JSON.parse(this.responseText));

    let thumbs_up = document.querySelector('div.post[data-id="' + 1 + '"]>div>div>ul>li>a');
    thumbs_up.innerHTML = "<i class='fa fa-thumbs-up'></i>";

    addEventListeners();    
}

function addedLikeHandler() {
    console.log("add2");
    
    if(this.status != 200) window.location = '/';
    let like = JSON.parse(this.responseText);

   // let new_like = createLike(like);

    let thumbs_up = document.querySelector('div.post[data-id="' + like.post_id + '"]>div>div>ul>li>a');
    thumbs_up.innerHTML = "<i class='fa fa-thumbs-up active'></i>";

    addEventListeners();
}

addEventListeners();