<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/channel/Banner.php');
  include_once('templates/scene-templates/channel/RecentPosts.php');
  include_once('templates/scene-templates/channel/Rules.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<link rel="stylesheet" href="/css/scenes/channel/ChannelIndex.css">

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

<script type="module" src="/js/scenes/channel/Channel.js"></script>

<?php getFooter(); ?>
