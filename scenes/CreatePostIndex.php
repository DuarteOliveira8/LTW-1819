<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/post/CreatePost.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>
<link rel="stylesheet" href="/css/scenes/post/CreatePostIndex.css">

<div class="container">
  <?php
    getCreatePost();
  ?>
</div>

<?php
  getFooter();
?>
