<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/post/CreatePost.php');
  include('templates/shared-components/Footer.php');

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
