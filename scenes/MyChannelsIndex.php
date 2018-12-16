<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/my-channels/MyChannels.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
 ?>

<link rel="stylesheet" href="/css/scenes/my-channels/MyChannelsIndex.css">

<?php
  getNavbar();
  getMyChannels();
?>
<script type="text/javascript">
  let username = "<?php echo $_SESSION['username']?>";
</script>
<script type="module" src="/js/scenes/my-channels/MyChannels.js"></script>

<?php getFooter(); ?>
