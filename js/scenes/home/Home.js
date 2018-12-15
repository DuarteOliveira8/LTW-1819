import {getPost} from '/js/shared-components/Post.js';
import {getChannel} from '/js/shared-components/Channel.js';

let mainChannels = document.getElementById('main-channels');
let recentPosts = document.getElementById('recent-posts');

let postOffset = 0;
let requesting = false;

let showMainChannels = new XMLHttpRequest();
let showRecentPosts = new XMLHttpRequest();

showMainChannels.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      mainChannels.innerHTML = `<h1>There are no channels. Create one now!</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      mainChannels.append(getChannel(response.data[i].name,
                           response.data[i].posts,
                           response.data[i].subscriptions,
                           response.data[i].banner));
    }
  }
};

showRecentPosts.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      recentPosts.innerHTML = `<h1>There are no posts.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      recentPosts.append(getPost(response.data[i].id,
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

showMainChannels.open("GET", "/api/home/main-channels", true);
showMainChannels.send();

showRecentPosts.open("POST", "/api/home/recent-posts", true);
let reqObj = {"offset":postOffset};
let request = JSON.stringify(reqObj);
showRecentPosts.send(request);

document.addEventListener('scroll', function (event) {
    if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && !requesting) {
      requesting = true;
      postOffset += 8;
      reqObj = {"offset": postOffset};
      request = JSON.stringify(reqObj);
      showRecentPosts.open("POST", "/api/home/recent-posts", true);
      showRecentPosts.setRequestHeader("Content-Type", "application/json");
      showRecentPosts.send(request);
    }
});
