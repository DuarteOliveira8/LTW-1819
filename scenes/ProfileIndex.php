<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/profile/Banner.php');
  include_once('templates/scene-templates/profile/ProfileNav.php');
  include_once("templates/shared-components/Post.php");
  include_once('templates/scene-templates/profile/profile-tabs/SubscriptionsTab.php');
  include_once('templates/scene-templates/profile/profile-tabs/PostsTab.php');
  include_once('templates/scene-templates/profile/profile-tabs/LikesTab.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<link rel="stylesheet" href="/css/scenes/profile/ProfileIndex.css">

<div class="profile-container">
  <?php
    getBanner();
    getProfileNav();

    getProfileSubscriptions();
    getProfilePosts();
    getProfileLikes();
  ?>
</div>

<script type="text/javascript" src="/js/scenes/profile/ProfileNav.js"></script>

<script type="module" src="/js/scenes/profile/Profile.js"></script>

<?php getFooter(); ?>
