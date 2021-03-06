<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/home/Banner.php');
  include_once('templates/scene-templates/home/MainChannels.php');
  include_once('templates/scene-templates/home/RecentPosts.php');
  include_once('templates/shared-components/Post.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar($user['username'], $user['avatar']);
?>

<link rel="stylesheet" href="/css/scenes/home/HomeIndex.css">

<div class="home-container">
  <?php
    getBanner();
    getMainChannels();
    getRecentPosts();
  ?>
</div>

<script type="text/javascript">
  let csrf = "<?php echo $_SESSION['csrf'] ?>";
  let user = "<?php echo $user['username'] ?>";
</script>
<script type="module" src="/js/scenes/home/Home.js"></script>

<?php getFooter(); ?>
