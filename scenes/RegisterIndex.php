<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/scene-templates/register/Register.php');
  include_once('templates/shared-components/Footer.php');
?>
<link rel="stylesheet" href="/css/scenes/register/RegisterIndex.css">

<?php
  getHeader();
  getRegister();
  getFooter();
?>
