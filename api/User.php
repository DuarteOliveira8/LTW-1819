<?php
  include_once('../includes/Session.php');
  include_once('../database/db-access/user.php');

  if (!isset($_SESSION['userID']))
    header('Location: ' . $_SERVER['HTTP_REFERER']);

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($user = getUser($_SESSION['userID'])) == false) {
      echo json_encode(array('error' => 'not_logged_in'));
    }
    else {
      echo json_encode($user);
    }
  }
  elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "POST";
  }
?>
