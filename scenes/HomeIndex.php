<link rel="stylesheet" href="/css/scenes/home/HomeIndex.css">

<?php
  include('includes/Session.php');
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/home/Banner.php');
  include('templates/scene-templates/home/main-channels/MainChannels.php');
  include('templates/scene-templates/home/main-channels/ChannelComponent.php');
  include('templates/scene-templates/home/MainPosts.php');
  include('templates/shared-components/Post.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<div class="home-container">
  <?php
    getBanner();
    getMainChannels();
    getMainPosts();
  ?>
</div>

<?php getFooter(); ?>
