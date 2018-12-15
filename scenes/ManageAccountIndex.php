<?php
  include_once('includes/Session.php');
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/manage-account/ManageAccount.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<link rel="stylesheet" href="/css/scenes/manage-account/ManageAccountIndex.css">

<div class="container">
  <?php
    getManageOptions();
  ?>
</div>

<script type="text/javascript">
  let username = "<?php echo $_SESSION['username']?>";
</script>
<script type="text/javascript" src="/js/scenes/manage-account/ManageAccount.js"></script>

<?php
  getFooter();
?>
