<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/channel/CreateChannel.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>
<link rel="stylesheet" href="/css/scenes/create-channel/CreateChannelIndex.css">

<div class="container">
  <?php
    getCreateChannel();
  ?>
</div>

<?php
  getFooter();
?>
