<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/manage-channel/ManageChannel.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
?>

<link rel="stylesheet" href="/css/scenes/manage-channel/ManageChannelIndex.css">

<script type="text/javascript">
  let username = "<?php echo $_SESSION['username']?>";
  let csrf = "<?php echo $_SESSION['csrf']?>";
</script>
<script type="module" src="/js/scenes/manage-channel/ManageChannel.js"></script>

<?php
  getNavbar($user['username'], $user['avatar']);
  getManageChannel();
  getFooter();
?>
