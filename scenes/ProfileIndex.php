<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/profile/Banner.php');
  include('templates/scene-templates/profile/ProfileNav.php');
  include("templates/shared-components/Post.php");
  include('templates/scene-templates/profile/profile-tabs/CommentsTab.php');
  include('templates/scene-templates/profile/profile-tabs/PostsTab.php');
  include('templates/scene-templates/profile/profile-tabs/LikesTab.php');
  include('templates/shared-components/Footer.php');

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

<script type="text/javascript" src="/js/scenes/profile/ProfileNav.js">

</script>

<?php getFooter(); ?>
