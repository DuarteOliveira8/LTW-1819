import {getPost} from '/js/shared-components/Post.js';
import {getChannel} from '/js/shared-components/Channel.js';

let posts = document.getElementById('posts');

let url = document.URL.split("/");
let channelId = url[4];

let postOffset = 0;
let requesting = false;

let showPosts = new XMLHttpRequest();

showPosts.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      posts.innerHTML = `<h1>There are no posts.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      posts.append(getPost(response.data[i].id,
                           response.data[i].title,
                           response.data[i].upvoteRatio,
                           response.data[i].username,
                           response.data[i].storyDate,
                           response.data[i].description,
                           response.data[i].comments,
                           response.data[i].avatar));
    }
    requesting = false;
  }
};

showPosts.open("POST", "/api/channel/" + channelId + "/posts", true);
let reqObj = {"offset":postOffset};
let request = JSON.stringify(reqObj);
showPosts.send(request);

document.addEventListener('scroll', function (event) {
    if ((document.body.scrollHeight == Math.ceil(document.body.scrollTop + window.innerHeight)) && !requesting) {
      requesting = true;
      postOffset += 8;
      reqObj = {"offset": postOffset};
      request = JSON.stringify(reqObj);
      showPosts.open("POST", "/api/channel/" + channelId + "/posts", true);
      showPosts.setRequestHeader("Content-Type", "application/json");
      showPosts.send(request);
    }
});
