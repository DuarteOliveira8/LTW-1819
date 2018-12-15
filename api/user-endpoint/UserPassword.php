<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');

  if (($user = getUser($matches['username'])) == false) {
    echo json_encode([
      'success' => false,
      'error' => 'username'
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

    if (authenticateUser(getUser($matches['username'])['email'], $request["current-password"]) === -1) {
      echo json_encode([
        'success' => false,
        'error' => 'current_password'
      ]);
      exit;
    }

    if ($request["password"] !== $request["confirm-password"]) {
      echo json_encode([
        'success' => false,
        'error' => 'different_password'
      ]);
      exit;
    }

    if (updateUserPassword($_SESSION['userID'], $request["password"])) {
      echo json_encode([
        'success' => true,
        'data' => 'password_updated'
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
