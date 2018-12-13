<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($user = getUser($matches['username'])) == false) {
      echo json_encode([
        'success' => false,
        'error' => 'username does not exist'
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
        'error' => 'User not logged in'
      ]);
      exit;
    }

    if ($_SESSION['userID'] !== getID($matches['username'])) {
      echo json_encode([
        'success' => false,
        'error' => 'Username does not correspond with user'
      ]);
      exit;
    }

    $request = json_decode(file_get_contents('php://input'), true);

    if (!isUsernameValidForUpdate($_SESSION['userID'], $request['Username'])) {
      echo json_encode([
        'success' => false,
        'error' => 'Username not valid'
      ]);
      exit;
    }

    if (!isEmailValidForUpdate($_SESSION['userID'], $request['Email'])) {
      echo json_encode([
        'success' => false,
        'error' => 'Email not valid'
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
