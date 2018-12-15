<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/home/Banner.php');
  include_once('templates/scene-templates/home/main-channels/MainChannels.php');
  include_once('templates/scene-templates/home/main-channels/ChannelComponent.php');
  include_once('templates/scene-templates/home/MainPosts.php');
  include_once('templates/shared-components/Post.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<link rel="stylesheet" href="/css/scenes/home/HomeIndex.css">

<div class="home-container">
  <?php
    getBanner();
    getMainChannels();
    getMainPosts();
  ?>
</div>

<?php getFooter(); ?>
