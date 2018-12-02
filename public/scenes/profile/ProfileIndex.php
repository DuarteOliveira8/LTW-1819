<?php
include('shared-components/Header.php');
include('shared-components/navbar/NavbarIndex.php');
include('scenes/profile/Banner.php');
include('shared-components/Footer.php');

getHeader();
getNavbar();
?>

<link rel="stylesheet" href="/css/scenes/profile/ProfileIndex.css">

<div class="profile-container">
  <?php
  getBanner();
  ?>
</div>

<?php getFooter(); ?>
