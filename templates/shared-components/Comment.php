<link rel="stylesheet" href="/css/shared-components/Comment.css">

<?php function getComment() { ?>
  <div class="comment-container">
    <div class="comment-header">
      <div class="comment-votes">
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

        <span class="comment-votes-num">10k</span>
      </div>


      <a href="/profile" class="user">
        <div class="user-avatar" style="background-image: url('/assets/images/default-profile.png')"></div>

        <div class="username">Firstname Lastname</div>
      </a>

      <div class="comment-date">
        dd/mm/yyyy
      </div>
    </div>

    <div class="comment-text">
    Hello, I am commenting on this post.
    </div>
  </div>
<?php } ?>
