import {showButton} from '/js/shared-components/Utils.js';

export function getComment(reply, commentId, numVotes, username, commentDate, commentDesc, numReplies, userAvatar) {

  let comment = document.createElement("div");
  comment.offset = 0;
  comment.className = "comment-container";
  comment.id = commentId;
  comment.innerHTML = `
    <header class="comment-header">
      <div class="comment-votes">
        <div class="vote-arrow-link">
          <svg class="vote-arrow-icon" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path d="M413.1,327.3l-1.8-2.1l-136-156.5c-4.6-5.3-11.5-8.6-19.2-8.6c-7.7,0-14.6,3.4-19.2,8.6L101,324.9l-2.3,2.6  C97,330,96,333,96,336.2c0,8.7,7.4,15.8,16.6,15.8v0h286.8v0c9.2,0,16.6-7.1,16.6-15.8C416,332.9,414.9,329.8,413.1,327.3z"/>
          </svg>
        </div>
        <div class="vote-arrow-link">
          <svg class="vote-arrow-icon" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path d="M98.9,184.7l1.8,2.1l136,156.5c4.6,5.3,11.5,8.6,19.2,8.6c7.7,0,14.6-3.4,19.2-8.6L411,187.1l2.3-2.6  c1.7-2.5,2.7-5.5,2.7-8.7c0-8.7-7.4-15.8-16.6-15.8v0H112.6v0c-9.2,0-16.6,7.1-16.6,15.8C96,179.1,97.1,182.2,98.9,184.7z"/>
          </svg>
        </div>

        <span class="comment-votes-num">
        </span>
      </div>

      <a href="/profile" class="user">
        <div class="user-avatar"></div>

        <div class="username"></div>
      </a>

      <div class="comment-date"></div>
    </header>

    <div class="comment-description"></div>

    <div class="comment-replies-num"></div>

    <div class="show-replies-btn">
      <div class="replies-btn-text">
        Show replies
      </div>
      <img class="replies-btn-arrow" alt="" src="assets/images/arrow-down.svg">
    </div>
  `;

  comment.querySelector(".comment-votes-num").textContent = numVotes;
  comment.querySelector(".username").textContent = username;
  comment.querySelector(".comment-date").textContent = commentDate;
  comment.querySelector(".comment-description").textContent = commentDesc;
  if (numReplies == 1)
    comment.querySelector(".comment-replies-num").textContent = numReplies + " Reply";
  else
    comment.querySelector(".comment-replies-num").textContent = numReplies + " Replies";
  comment.querySelector(".user-avatar").style.backgroundImage = "url('/assets/images/users/" + userAvatar + "')";


  let repliesReq = new XMLHttpRequest();
  let upvoteReq = new XMLHttpRequest();
  let downvoteReq = new XMLHttpRequest();
  let voteReq = new XMLHttpRequest();


  repliesReq.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);

      if (!response.success) {
        return;
      }

      for(let i = 0; i < response.data.length; i++) {
        comment.append(getComment(true,
                                  response.data[i].id,
                                  response.data[i].upvoteRatio,
                                  response.data[i].username,
                                  response.data[i].commentDate,
                                  response.data[i].description,
                                  0,
                                  response.data[i].avatar));
      }

      if (comment.querySelectorAll(".show-comments-btn")[1] != null) {
        comment.querySelectorAll(".show-comments-btn")[1].remove();
      }

      if (response.data.length == 4) {
        let loadMore = showButton();
        comment.appendChild(loadMore);
        loadMore.addEventListener("click", function(e) {
          e.stopPropagation();

          let reqObjReplies = {"offset": post.offset};
          let reqStrReplies = JSON.stringify(reqObjReplies);

          repliesReq.open("POST", "/api/comment/"+commentId+"/replies", true);
          repliesReq.setRequestHeader("Content-Type", "application/json");
          repliesReq.send(reqStrReplies);
        });
      }

      comment.offset += 4;
    }
  }

  upvoteReq.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);
      console.log(response);

      if (!response.success) {
        return;
      }

      let upvoteArrow = comment.querySelectorAll('.vote-arrow-link')[0];
      let downvoteArrow = comment.querySelectorAll('.vote-arrow-link')[1];
      if (response.data.upvoted) {
        upvoteArrow.style.fill = "green";
        downvoteArrow.style.fill = "black";
      }
      else {
        upvoteArrow.style.fill = "black";
      }

      comment.querySelector('.comment-votes-num').textContent = response.data.upvoteRatio;
    }
  }

  downvoteReq.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);

      if (!response.success) {
        return;
      }

      let upvoteArrow = comment.querySelectorAll('.vote-arrow-link')[0];
      let downvoteArrow = comment.querySelectorAll('.vote-arrow-link')[1];
      if (response.data.downvoted) {
        downvoteArrow.style.fill = "red";
        upvoteArrow.style.fill = "black";
      }
      else {
        downvoteArrow.style.fill = "black";
      }

      comment.querySelector('.comment-votes-num').textContent = response.data.upvoteRatio;
    }
  }

  voteReq.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);

      if (!response.success) {
        return;
      }

      let upvoteArrow = comment.querySelectorAll('.vote-arrow-link')[0];
      let downvoteArrow = comment.querySelectorAll('.vote-arrow-link')[1];
      if (response.data == "upvoted") {
        downvoteArrow.style.fill = "black";
        upvoteArrow.style.fill = "green";
      }
      else if (response.data == "downvoted") {
        downvoteArrow.style.fill = "red";
        upvoteArrow.style.fill = "black";
      }
      else {
        downvoteArrow.style.fill = "black";
        upvoteArrow.style.fill = "black";
      }
    }
  }


  if (reply) {
    comment.querySelector(".show-replies-btn").style.display = "none";
    comment.querySelector(".comment-replies-num").style.display = "none";
  }
  else {
    comment.querySelector(".show-replies-btn").addEventListener("click", function(e) {
      e.stopPropagation();

      if (comment.querySelector(".replies-btn-text").textContent == "Show replies") {
        let reqObjReplies = {"offset": comment.offset};
        let reqStrReplies = JSON.stringify(reqObjReplies);

        repliesReq.open("POST", "/api/comment/"+commentId+"/replies", true);
        repliesReq.setRequestHeader("Content-Type", "application/json");
        repliesReq.send(reqStrReplies);

        comment.querySelector(".replies-btn-text").textContent = "Hide replies";
        comment.querySelector(".replies-btn-arrow").src = "assets/images/arrow-up.svg";
      }
      else {
        let replies = comment.querySelectorAll('.comment-container');
        for (var i = 0; i < replies.length; i++) {
          replies[i].remove();
        }

        comment.querySelector(".replies-btn-text").textContent = "Show replies";
        comment.querySelector(".replies-btn-arrow").src = "assets/images/arrow-down.svg";

        if (comment.querySelectorAll(".show-replies-btn")[1] != null) {
          comment.querySelectorAll(".show-replies-btn")[1].remove();
        }

        comment.offset = 0;
      }
    });
  }

  comment.querySelectorAll('.vote-arrow-link')[0].addEventListener("click", function(e) {
    e.stopPropagation();

    let reqObjUpvote = {"commentId": commentId};
    let reqStrUpvote = JSON.stringify(reqObjUpvote);

    upvoteReq.open("POST", "/api/comment/"+user+"/upvote", true);
    upvoteReq.setRequestHeader("Content-Type", "application/json");
    upvoteReq.setRequestHeader("csrf", csrf);
    upvoteReq.send(reqStrUpvote);
  });

  comment.querySelectorAll('.vote-arrow-link')[1].addEventListener("click", function(e) {
    e.stopPropagation();

    let reqObjUpvote = {"commentId": commentId};
    let reqStrUpvote = JSON.stringify(reqObjUpvote);

    downvoteReq.open("POST", "/api/comment/"+user+"/downvote", true);
    downvoteReq.setRequestHeader("Content-Type", "application/json");
    downvoteReq.setRequestHeader("csrf", csrf);
    downvoteReq.send(reqStrUpvote);
  });

  let reqObjVote = {"commentId": commentId};
  let reqStrVote = JSON.stringify(reqObjVote);

  voteReq.open("POST", "/api/comment/"+user+"/vote", true);
  voteReq.setRequestHeader("Content-Type", "application/json");
  voteReq.setRequestHeader("csrf", csrf);
  voteReq.send(reqStrVote);

  return comment;
}
