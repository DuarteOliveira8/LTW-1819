<link rel="stylesheet" href="/css/scenes/channel/ChannelIndex.css">

<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/channel/Banner.php');
  include('templates/scene-templates/channel/RecentPosts.php');
  include('templates/scene-templates/channel/Rules.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<div class="channel-container">
  <?php
    getChannelBanner();
  ?>

  <div class="content">
    <?php
      getRecentPosts();
      getRules();
    ?>
  </div>
</div>

<?php getFooter(); ?>
