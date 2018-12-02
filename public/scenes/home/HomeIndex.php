<?php
include('../../shared-components/Header.php');
include('../../shared-components/navbar/NavbarIndex.php');
include('./Banner.php');
include('./main-channels/MainChannels.php');
include('./main-channels/ChannelComponent.php');
include('./MainPosts.php');
include('../../shared-components/Post.php');
include('../../shared-components/Footer.php');

getHeader();
getNavbar();
?>

<link rel="stylesheet" href="/css/home/HomeIndex.css">

<div class="home-container">
  <?php
  getBanner();
  getMainChannels();
  getMainPosts();
  ?>
</div>

<?php getFooter(); ?>
