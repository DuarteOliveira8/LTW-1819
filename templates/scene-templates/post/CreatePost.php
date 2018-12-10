<link rel="stylesheet" href="/css/scenes/post/CreatePost.css">

<?php
  include('templates/shared-components/input/TextArea.php');
?>

<?php function getCreatePost() { ?>
    <div class="create-box">

      <div class="webbitLogo">
        <a href="/">
          <img src="/assets/images/webbit-rabbit.png" alt="Webbit logo" height="75px" width="65px"/>
        </a>
      </div>

      <div class="windowLabel">Create a Post</div>

      <form method="POST">

        <div class="post-title">
          <?php input('text', "Post Title:", "post-title", "Post Title", true); ?>
        </div>

        <div class="post-description">
          <?php textarea("Post Description:", "post-description", 20, 50, "Post Description", true); ?>
        </div>

        <div class="submitPost">
          <button class="submitButton" type="submit">Start</button>
        </div>
      </form>
    </div>
<?php } ?>
