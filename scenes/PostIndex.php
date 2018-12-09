<?php
  include('includes/Session.php');
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/post/Post.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
  getPost();
  getFooter();
?>
