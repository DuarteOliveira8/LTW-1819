<?php
  include_once('includes/Session.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/scene-templates/login/Login.php');
  include_once('templates/shared-components/Footer.php');

  getHeader();
?>

<link rel="stylesheet" href="/css/scenes/login/LoginIndex.css">

<?php
if (isset($_SESSION['userID']))
  header("Location: /");
getLogin();
getFooter();
?>
