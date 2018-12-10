<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/post/Post.php');
  include_once('templates/scene-templates/post/Comments.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<div class="container">
  <?php
    getPost();
    getComments();
  ?>
</div>

<?php
  getFooter();
?>
