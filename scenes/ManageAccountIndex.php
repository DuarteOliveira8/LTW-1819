<?php
  include_once('includes/Session.php');
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/manage-account/ManageAccount.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar($user['username'], $user['avatar']);
?>

<link rel="stylesheet" href="/css/scenes/manage-account/ManageAccountIndex.css">

<div class="container">
  <?php
    if (!isset($_SESSION['userID']))
      header("location: /404");
    getManageOptions();

  ?>
</div>

<script type="text/javascript">
  let username = "<?php echo $_SESSION['username']?>";
  let csrf = "<?php echo $_SESSION['csrf']?>";
</script>
<script type="module" src="/js/scenes/manage-account/ManageAccount.js"></script>

<?php
  getFooter();
?>
