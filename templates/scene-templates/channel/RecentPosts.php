<link rel="stylesheet" href="/css/scenes/channel/RecentPosts.css">

<?php
  include('templates/shared-components/Post.php')
?>

<?php function getRecentPosts() { ?>
  <div class="posts-container">
    <h1 class="recent-title">
      Recent posts
    </h1>

    <?php for ($i=0; $i < 8; $i++) {
      getPost();
    } ?>
  </div>
<?php } ?>
