<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');

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

    if (!isChannelNameValid($request['name'])) {
      echo json_encode([
        'success' => false,
        'error' => 'name'
      ]);
      exit;
    }

    if (createChannel($request['name'], $request['slogan'], $_SESSION['userID']) !== -1) {
      echo json_encode([
        'success' => true,
        'data' => 'chanel_created'
      ]);
      exit;
    }
  }
?>
