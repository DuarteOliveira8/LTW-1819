<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/create-post/CreatePost.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
?>

<link rel="stylesheet" href="/css/scenes/create-post/CreatePostIndex.css">

<?php
  getNavbar($user['username'], $user['avatar']);
  getCreatePost();
?>

<script type="text/javascript">
  let username = "<?php echo $_SESSION['username']?>";
  let csrf = "<?php echo $_SESSION['csrf']?>";
</script>
<script type="text/javascript" src="/js/scenes/create-post/CreatePost.js"></script>

<?php
  getFooter();
?>
