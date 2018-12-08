<?php
  include_once('../src/auth/Session.php');
  include_once('../src/user.php');

  function register() {
    $username = $_POST['username'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    $birthDate = $year+'-'+$month+'-'+$day;

    if (!preg_match("/[a-zA-Z0-9]+$/", $password)) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Password can only contain letters and numbers!');
      die(header('Location: /register'));
    }
    elseif ($password != $confirmPassword) {
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Passwords must be equal!');
      die(header('Location: /register'));
    }

    try {
      createUser($username, $firstName, $lastName, $email, $password, $birthDate);
      $_SESSION['username'] = $username;
      $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Signed up and logged in!');
      header('Location: /');
    } catch (PDOException $e) {
      die($e->getMessage());
      $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
      header('Location: /register');
    }
  }
?>
