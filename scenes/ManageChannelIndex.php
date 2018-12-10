<link rel="stylesheet" href="/css/scenes/manage-channel/ManageChannelIndex.css">

<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/manage-channel/ManageChannel.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<div class="container">
  <?php
    getManageChannel();
  ?>
</div>

<?php
  getFooter();
?>
