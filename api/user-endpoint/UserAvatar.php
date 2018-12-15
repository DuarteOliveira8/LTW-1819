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

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($avatar = getUserAvatar($matches['username'])) == false) {
      echo json_encode([
        'success' => false,
        'error' => 'null'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => $avatar
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

    if (!preg_match('/^([a-zA-Z0-9\s_\\.\-\(\):])+(.png|.jpg|.jpeg)$/', $request["avatar"])) {
      echo json_encode([
        'success' => false,
        'error' => 'file_name'
      ]);
      exit;
    }

    if (updateUserAvatar($_SESSION['userID'], $request["avatar"])) {
      if (($avatar = getUserAvatar($_SESSION['userID'])) == false) {
        echo json_encode([
          'success' => false,
          'error' => 'null'
        ]);
        exit;
      }

      echo json_encode([
        'success' => true,
        'data' => $avatar
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
