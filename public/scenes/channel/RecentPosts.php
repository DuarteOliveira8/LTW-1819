<link rel="stylesheet" href="/css/scenes/channel/RecentPosts.css">

<?php
include('shared-components/Post.php')
?>

<?php function getRecentPosts() { ?>
  <div class="posts-container">
    <?php for ($i=0; $i < 8; $i++) {
      getPost();
    } ?>
  </div>
<?php } ?>
