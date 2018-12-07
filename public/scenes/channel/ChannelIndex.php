<link rel="stylesheet" href="/css/scenes/channel/ChannelIndex.css">

<?php
include('shared-components/Header.php');
include('shared-components/navbar/NavbarIndex.php');
include('scenes/channel/ChannelBanner.php');
include('shared-components/Footer.php');

getHeader();
getNavbar();
?>

<div class="channel-container">
  <?php
  getChannelBanner();
  ?>
</div>

<?php getFooter(); ?>
