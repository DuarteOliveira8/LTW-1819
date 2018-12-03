<?php
include('shared-components/Header.php');
include('shared-components/navbar/NavbarIndex.php');
include('scenes/profile/Banner.php');
include('scenes/profile/ProfileNav.php');
include('scenes/profile/profile-tabs/PostsTab.php');
include('shared-components/Footer.php');

getHeader();
getNavbar();
?>

<link rel="stylesheet" href="/css/scenes/profile/ProfileIndex.css">

<div class="profile-container">
  <?php
  getBanner();
  getProfileNav();
  ?>

  <div class="tab-container">
    <?php
    getProfilePosts();
    ?>
  </div>
</div>

<?php getFooter(); ?>
