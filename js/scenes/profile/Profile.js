import {getPost} from '/js/shared-components/Post.js';
import {getChannel} from '/js/shared-components/Channel.js';

let posts = document.getElementById('posts');
let subscriptions = document.getElementById('subscriptions');
let postVoted = document.getElementById('likes');

let url = document.URL.split("/");
let userName = url[4];

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
      posts.append(getPost(response.data[i].id, response.data[i].title, response.data[i].upvoteRatio, response.data[i].username, response.data[i].storyDate, response.data[i].description, response.data[i].comments, response.data[i].avatar));
    }
  }
};

showSubscriptions.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      subscriptions.innerHTML = `<h1>This user is not subscribed to any channels.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      subscriptions.append(getChannel(response.data[i].name, response.data[i].posts, response.data[i].subscriptions, response.data[i].banner));
    }
  }
}

showVotes.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      postVoted.innerHTML = `<h1>This user hasn't voted on any posts.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      postVoted.append(getPost(response.data[i].id, response.data[i].title, response.data[i].upvoteRatio, response.data[i].username, response.data[i].storyDate, response.data[i].description, response.data[i].comments, response.data[i].avatar));
    }
  }
}

showProfilePosts.open("GET", "/api/user/" + userName + "/posts", true);
showProfilePosts.send();

showSubscriptions.open("GET", "/api/user/" + userName + "/subscribe", true);
showSubscriptions.send();

showVotes.open("GET", "/api/user/" + userName + "/votes", true);
showVotes.send();
