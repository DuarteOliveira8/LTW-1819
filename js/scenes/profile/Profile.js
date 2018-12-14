import {getPost} from '/js/shared-components/Post.js';
import {getChannel} from '/js/shared-components/Channel.js';

let posts = document.getElementById('posts');
let subscriptions = document.getElementById('subscriptions');
let postVoted = document.getElementById('likes');

let url = document.URL.split("/");
let userName = url[4];

// let showProfilePosts = new XMLHttpRequest();
// let showSubscriptions = new XMLHttpRequest();

// showProfilePosts.onreadystatechange = function() {
//   if (this.readyState === 4 && this.status === 200) {
//     let response = JSON.parse(this.responseText);
//     if (!response.success) {
//
//     }
//     for(let i = 0; i < response.length; i++) {
//       getPost(response[i].Title, response[i].UpvoteRatio, response[i].Username, response[i].StoryDate, response[i].Description, response[i].Comments, response[i].Avatar);
//     }
//   }
// };

// showSubscriptions.onreadystatechange = function() {
//   if (this.readyState === 4 && this.status === 200) {
//     let response = JSON.parse(this.responseText);
//     if (!response.success) {
//
//     }
//     for(let i = 0; i < response.length; i++) {
//       subscriptions.append(getChannel(response[i].))
//     }
//   }
// }

// showProfilePosts.open("GET", "/api/user/" + userName + "posts", true);
// showProfilePosts.send();

for(let i = 0; i < 5; i++) {
  likes.append(getPost("Mega Cursed Post", 24, "very_cursed_individual", "1990-01-01", "Tis very cursed oops", 24, "3.jpg"));
}

for(let i = 0; i < 5; i++) {
  subscriptions.append(getChannel("Cursed Images", 15, 420, "default-background.jpg"));
}

for(let i = 0; i < 5; i++) {
  posts.append(getPost("Cursed Post", 15, "cursed_person", "1998-12-15", "Tis Cursed", 15, "3.jpg"));
}
