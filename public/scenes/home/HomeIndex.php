<link rel="stylesheet" href="/css/scenes/home/HomeIndex.css">

<?php
include('shared-components/Header.php');
include('shared-components/navbar/NavbarIndex.php');
include('scenes/home/Banner.php');
include('scenes/home/main-channels/MainChannels.php');
include('scenes/home/main-channels/ChannelComponent.php');
include('scenes/home/MainPosts.php');
include('shared-components/Post.php');
include('shared-components/Footer.php');

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
