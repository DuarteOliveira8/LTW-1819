<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/create-channel/CreateChannel.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
  getNavbar($user['username'], $user['avatar']);
?>

<link rel="stylesheet" href="/css/scenes/create-channel/CreateChannelIndex.css">

<script type="text/javascript">
  let username = "<?php echo $_SESSION['username']?>";
  let csrf = "<?php echo $_SESSION['csrf']?>";
</script>
<script type="module" src="/js/scenes/create-channel/createChannel.js">
</script>


<?php
  getCreateChannel();
  getFooter();
  
  
?>
