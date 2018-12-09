<?php
  include_once('../../includes/Session.php');
  include_once('../../database/db-access/user.php');

  $email = $_POST['email'];
  $password = $_POST['password'];

  if (($userID = authenticateUser($email, $password)) !== -1) {
    $_SESSION['userID'] = $userID;
    header('Location: /');
  }
  else {
    $_SESSION['ERROR'] = 'Either e-mail or password is incorrect!';
    header('Location: /login');
  }
?>
