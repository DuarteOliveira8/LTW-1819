<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/channel/CreateChannel.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>
<link rel="stylesheet" href="/css/scenes/channel/CreateChannelIndex.css">

<div class="container">
  <?php
    getCreateChannel();
  ?>
</div>

<?php
  getFooter();
?>
