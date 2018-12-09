<?php
  include_once('../../includes/Session.php');

  session_destroy();
  session_start();

  header('Location: /');
?>
