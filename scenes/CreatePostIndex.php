<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/create-post/CreatePost.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
?>

<link rel="stylesheet" href="/css/scenes/create-post/CreatePostIndex.css">

<?php
  getNavbar();
  getCreatePost();
?>

<?php
  getFooter();
?>
