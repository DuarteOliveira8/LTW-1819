<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($user = getUser($matches['username'])) == false) {
      echo json_encode([
        'success' => false,
        'error' => 'username'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => $user
    ]);
    exit;
  }


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['userID'])) {
      echo json_encode([
        'success' => false,
        'error' => 'not_logged_in'
      ]);
      exit;
    }

    $request = json_decode(file_get_contents('php://input'), true);

    if ($_SESSION['userID'].$_SESSION['csrf'] !== getID($matches['username']).$_SERVER['HTTP_CSRF']) {
      echo json_encode([
        'success' => false,
        'error' => 'validation'
      ]);
      exit;
    }

    if (!isUsernameValidForUpdate($_SESSION['userID'], $request['Username'])) {
      echo json_encode([
        'success' => false,
        'error' => 'username'
      ]);
      exit;
    }

    if (!isEmailValidForUpdate($_SESSION['userID'], $request['Email'])) {
      echo json_encode([
        'success' => false,
        'error' => 'email'
      ]);
      exit;
    }

    if (updateUser($_SESSION['userID'], $request['Username'], $request['FirstName'], $request['LastName'], $request['Email'], $request['Bio'], $request['BirthDate'])) {
      $username = getUsername($_SESSION['userID']);
      $user = getUser($username);
      echo json_encode([
        'success' => true,
        'data' => $user
      ]);
      exit;
    }

    echo json_encode([
      'success' => false,
      'error' => 'null'
    ]);
    exit;
  }
?>
