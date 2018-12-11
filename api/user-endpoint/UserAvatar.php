<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');

  if (!isset($_SESSION['userID'])) {
    echo json_encode(array('error' => 'user_not_logged_in'));
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($avatar = getUserAvatar($_SESSION['userID'])) == false) {
      echo json_encode(array('error' => 'null'));
    }
    else {
      echo json_encode($avatar);
    }
  }
  elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    if (!preg_match('/^([a-zA-Z0-9\s_\\.\-\(\):])+(.png|.jpg|.jpeg)$/', $request["Avatar"])) {
      echo json_encode(array('error' => 'wrong_file_type'));
    }
    elseif (updateUserAvatar($_SESSION['userID'], $request["Avatar"])) {
      echo json_encode(array('success' => 'avatar_updated'));
    }
    else {
      echo json_encode(array('error' => 'null'));
    }
  }
?>
