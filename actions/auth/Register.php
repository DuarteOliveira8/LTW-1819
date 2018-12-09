<?php
  include_once('../../includes/Session.php');
  include_once('../../database/db-access/user.php');

  $username = $_POST['username'];
  $fisrtName = $_POST['first-name'];
  $lastName = $_POST['last-name'];
  $day = $_POST['day'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];

  $birthDate = "{$year}-{$month}-{$day}";

  if (!isUsernameValid($username)) {
    $_SESSION['ERROR'] = 'Username not valid!';
    header('Location: /register');
  }
  elseif (!isEmailValid($email)) {
    $_SESSION['ERROR'] = 'Email not valid!';
    header('Location: /register');
  }
  elseif ($password != $confirmPassword) {
    $_SESSION['ERROR'] = 'Passwords must be equal!';
    header('Location: /register');
  }
  elseif (($userID = createUser($username, $fisrtName, $lastName, $email, $password, $birthDate)) != -1) {
    $_SESSION['userID'] = $userID;
    unset($_SESSION['ERROR']);
    header('Location: /');
  }
  else {
    $_SESSION['ERROR'] = 'Idk ma men!';
    header('Location: /register');
  }
?>
