import {getComment} from '/js/shared-components/Comment.js'

let comments = document.getElementById('comments');

let showComments = new XMLHttpRequest();

let requesting = false;
let commentOffset = 0;

let url = document.URL.split("/");
let postId = url[4];

showComments.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      comments.innerHTML = `<h1>There are no comments.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      comments.append(getComment(false,
        response.data[i].id,
        response.data[i].upvoteRatio,
        response.data[i].username,
        response.data[i].commentDate,
        response.data[i].description,
        response.data[i].replies,
        response.data[i].avatar
      ));
    }
    requesting = false;
  }
};

showComments.open("POST", "/api/post/" + postId + "/comments", true);
let reqObj = {"offset":commentOffset};
let request = JSON.stringify(reqObj);
showComments.send(request);

document.addEventListener('scroll', function (event) {
    if ((document.body.scrollHeight <= Math.ceil(document.body.scrollTop + window.innerHeight)) && !requesting) {
      requesting = true;
      commentOffset += 4;
      reqObj = {"offset": commentOffset};
      request = JSON.stringify(reqObj);
      showComments.open("POST", "/api/post/" + postId + "/comments", true);
      showComments.setRequestHeader("Content-Type", "application/json");
      showComments.send(request);
    }
});
