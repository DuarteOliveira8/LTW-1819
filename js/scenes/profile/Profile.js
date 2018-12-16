import {getPost} from '/js/shared-components/Post.js';
import {getChannel} from '/js/shared-components/Channel.js';

let posts = document.getElementById('posts');
let subscriptions = document.getElementById('subscriptions');
let postVoted = document.getElementById('likes');

let url = document.URL.split("/");
let userName = url[4];

let postOffsetPosts = 0;
let postOffsetVotes = 0;
let requesting = 0;

let showProfilePosts = new XMLHttpRequest();
let showSubscriptions = new XMLHttpRequest();
let showVotes = new XMLHttpRequest();

showProfilePosts.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      posts.innerHTML = `<h1>This user has no posts.</h1>`;
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

showSubscriptions.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      subscriptions.innerHTML = `<h1>This user is not subscribed to any channels.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      subscriptions.append(getChannel(response.data[i].name,
                                      response.data[i].posts,
                                      response.data[i].subscriptions,
                                      response.data[i].banner));
    }
  }
};

showVotes.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      postVoted.innerHTML = `<h1>This user hasn't voted on any posts.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      postVoted.append(getPost(response.data[i].id,
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

showSubscriptions.open("GET", "/api/user/" + userName + "/subscribe", true);
showSubscriptions.send();

showProfilePosts.open("POST", "/api/user/" + userName + "/posts", true);
let reqObjPosts = {"offset":postOffsetPosts};
let requestPosts = JSON.stringify(reqObjPosts);
showProfilePosts.send(requestPosts);

showVotes.open("POST", "/api/user/" + userName + "/votes", true);
let reqObjVotes = {"offset":postOffsetVotes};
let requestVotes = JSON.stringify(reqObjVotes);
showVotes.send(requestVotes);

document.addEventListener('scroll', function (event) {
    if ((document.body.scrollHeight == Math.ceil(document.body.scrollTop + window.innerHeight)) && !requesting) {
      if (!postVoted.hidden) {
        requesting = true;
        postOffsetVotes += 8;
        reqObjVotes = {"offset": postOffsetVotes};
        requestVotes = JSON.stringify(reqObjVotes);
        console.log(requestVotes);
        showVotes.open("POST", "/api/user/" + userName + "/votes", true);
        showVotes.setRequestHeader("Content-Type", "application/json");
        showVotes.send(requestVotes);
      }
      else if (!posts.hidden) {
        requesting = true;
        postOffsetPosts += 8;
        reqObjPosts = {"offset": postOffsetPosts};
        requestPosts = JSON.stringify(reqObjPosts);
        showProfilePosts.open("POST", "/api/user/" + userName + "/posts", true);
        showProfilePosts.setRequestHeader("Content-Type", "application/json");
        showProfilePosts.send(requestPosts);
      }
    }
});
