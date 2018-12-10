<link rel="stylesheet" href="/css/scenes/create-channel/CreateChannelIndex.css">

<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/create-channel/CreateChannel.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<div class="container">
  <?php
    getCreateChannel();
  ?>
</div>

<?php
  getFooter();
?>
