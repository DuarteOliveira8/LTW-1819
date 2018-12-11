<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');

  if (!isset($_SESSION['userID'])) {
    echo json_encode(array('error' => 'user_not_logged_in'));
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    if ($request["Password"] !== $request["Confirm-password"]) {
      echo json_encode(array('error' => 'different_passwords'));
    }
    elseif (updateUserPassword($_SESSION['userID'], $request["Password"])) {
      echo json_encode(array('success' => 'password_updated'));
    }
    else {
      echo json_encode(array('error' => 'null'));
    }
  }
?>
