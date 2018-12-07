<link rel="stylesheet" href="/css/scenes/channel/ChannelIndex.css">

<?php
include('shared-components/Header.php');
include('shared-components/navbar/NavbarIndex.php');
include('scenes/channel/Banner.php');
include('scenes/channel/RecentPosts.php');
include('scenes/channel/Rules.php');
include('shared-components/Footer.php');

getHeader();
getNavbar();
?>

<div class="channel-container">
  <?php getChannelBanner(); ?>

  <div class="content">
    <?php
    getRecentPosts();
    getRules();
    ?>
  </div>
</div>

<?php getFooter(); ?>
