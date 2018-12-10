<link rel="stylesheet" href="/css/scenes/create-post/CreatePostIndex.css">

<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/create-post/CreatePost.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<div class="container">
  <?php
    getCreatePost();
  ?>
</div>

<?php
  getFooter();
?>
