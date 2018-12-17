import {getComment} from '/js/shared-components/Comment.js';
import {showButton} from '/js/shared-components/Utils.js';

export function getPost(postId, title, numVotes, username, postDate, postDesc, numComments, userAvatar) {

  let post = document.createElement("div");
  post.offset = 0;
  post.className = "post-container";
  post.id = postId;

  post.addEventListener("click", function(e){
    e.stopPropagation();
    document.location.href="/post/" + postId;
  });

  post.innerHTML = `
    <header class="post-header">
      <div class="post-votes">
        <a href="#" class="vote-arrow-link">
          <svg class="vote-arrow-icon" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path d="M413.1,327.3l-1.8-2.1l-136-156.5c-4.6-5.3-11.5-8.6-19.2-8.6c-7.7,0-14.6,3.4-19.2,8.6L101,324.9l-2.3,2.6  C97,330,96,333,96,336.2c0,8.7,7.4,15.8,16.6,15.8v0h286.8v0c9.2,0,16.6-7.1,16.6-15.8C416,332.9,414.9,329.8,413.1,327.3z"/>
          </svg>
        </a>
        <a href="#" class="vote-arrow-link">
          <svg class="vote-arrow-icon" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path d="M98.9,184.7l1.8,2.1l136,156.5c4.6,5.3,11.5,8.6,19.2,8.6c7.7,0,14.6-3.4,19.2-8.6L411,187.1l2.3-2.6  c1.7-2.5,2.7-5.5,2.7-8.7c0-8.7-7.4-15.8-16.6-15.8v0H112.6v0c-9.2,0-16.6,7.1-16.6,15.8C96,179.1,97.1,182.2,98.9,184.7z"/>
          </svg>
        </a>

        <span class="votes-num">
        </span>
      </div>

      <div class="post-title">
      </div>

      <a href="/profile" class="user">
        <div class="user-avatar" style="background-image: url('/assets/images/users/default-profile.png')"></div>

        <div class="username">
        </div>
      </a>

      <div class="post-date">
      </div>
    </header>

    <div class="post-description">
    </div>

    <div class="post-comments-num">
    </div>

    <div class="show-comments-btn">
      <div class="comments-btn-text">Show comments</div>
      <img class="comments-btn-arrow" alt="" src="/assets/images/arrow-down.svg">
    </div>
  `;


  post.querySelector(".votes-num").textContent = numVotes;
  post.querySelector(".post-title").textContent = title;
  post.querySelector(".username").textContent = username;
  post.querySelector(".post-date").textContent = postDate;
  post.querySelector(".post-description").textContent = postDesc;
  if (numComments == 1)
    post.querySelector(".post-comments-num").textContent = numComments + " Comment";
  else
    post.querySelector(".post-comments-num").textContent = numComments + " Comments";
  post.querySelector(".user-avatar").style.backgroundImage = "url('/assets/images/users/" + userAvatar + "')";


  let commentsReq = new XMLHttpRequest();

  commentsReq.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);

      if (!response.success) {
        return;
      }

      for(let i = 0; i < response.data.length; i++) {
        post.append(getComment(false,
                               response.data[i].id,
                               response.data[i].upvoteRatio,
                               response.data[i].username,
                               response.data[i].commentDate,
                               response.data[i].description,
                               response.data[i].replies,
                               response.data[i].avatar));
      }

      if (post.querySelectorAll(".show-comments-btn")[1] != null) {
        post.querySelectorAll(".show-comments-btn")[1].remove();
      }

      if (response.data.length == 4) {
        let loadMore = showButton()
        post.appendChild(loadMore);
        loadMore.addEventListener("click", function(e) {
          e.stopPropagation();

          let reqObjComments = {"offset": post.offset};
          let reqStrComments = JSON.stringify(reqObjComments);

          commentsReq.open("POST", "/api/post/"+postId+"/comments", true);
          commentsReq.setRequestHeader("Content-Type", "application/json");
          commentsReq.send(reqStrComments);
        });
      }

      post.offset += 4;
    }
  }

  post.querySelector(".show-comments-btn").addEventListener("click", function(e) {
    e.stopPropagation();

    if (post.querySelector(".comments-btn-text").textContent == "Show comments") {
      let reqObjComments = {"offset": post.offset};
      let reqStrComments = JSON.stringify(reqObjComments);

      commentsReq.open("POST", "/api/post/"+postId+"/comments", true);
      commentsReq.setRequestHeader("Content-Type", "application/json");
      commentsReq.send(reqStrComments);

      post.querySelector(".comments-btn-text").textContent = "Hide comments";
      post.querySelector(".comments-btn-arrow").src = "/assets/images/arrow-up.svg";
    }
    else {
      let comments = post.querySelectorAll('.comment-container');
      for (var i = 0; i < comments.length; i++) {
        comments[i].remove();
      }

      post.querySelector(".comments-btn-text").textContent = "Show comments";
      post.querySelector(".comments-btn-arrow").src = "/assets/images/arrow-down.svg";

      if (post.querySelectorAll(".show-comments-btn")[1] != null) {
        post.querySelectorAll(".show-comments-btn")[1].remove();
      }

      post.offset = 0;
    }
  });

  return post;
}
