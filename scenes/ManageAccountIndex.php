<link rel="stylesheet" href="/css/scenes/manage-account/ManageAccountIndex.css">

<?php
  include('templates/shared-components/Header.php');
  include('templates/shared-components/navbar/NavbarIndex.php');
  include('templates/scene-templates/manage-account/ManageAccount.php');
  include('templates/shared-components/Footer.php');

  getHeader();
  getNavbar();
?>

<div class="container">
  <?php
    getManageOptions();
  ?>
</div>

<?php
  getFooter();
?>
