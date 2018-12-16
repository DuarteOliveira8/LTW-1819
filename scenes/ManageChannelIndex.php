<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/manage-channel/ManageChannel.php');
  include('templates/shared-components/Footer.php');

  getHeader();
?>

<link rel="stylesheet" href="/css/scenes/manage-channel/ManageChannelIndex.css">

<?php
  getNavbar($user['username'], $user['avatar']);
  getManageChannel();
  getFooter();
?>
