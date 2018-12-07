<?php
include('shared-components/Header.php');
include('shared-components/navbar/NavbarIndex.php');
include('scenes/profile/Banner.php');
include('scenes/profile/ProfileNav.php');
include("shared-components/Post.php");
include('scenes/profile/profile-tabs/CommentsTab.php');
include('scenes/profile/profile-tabs/PostsTab.php');
include('scenes/profile/profile-tabs/LikesTab.php');
include('shared-components/Footer.php');

getHeader();
getNavbar();
?>

<link rel="stylesheet" href="/css/scenes/profile/ProfileIndex.css">
<link rel="stylesheet" href="/css/scenes/profile/Tab.css">

<div class="profile-container">
  <?php
  getBanner();
  getProfileNav();

  getProfileComments();
  getProfilePosts();
  getProfileLikes();
  ?>
</div>

<script type="text/javascript" src="/js/ProfileNav.js">

</script>

<?php getFooter(); ?>
