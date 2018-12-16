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
    $request = json_decode(file_get_contents('php://input'), true);

    if (($votes = getUserVotes($request['offset'], getID($matches['username']))) == false) {
      echo json_encode([
        'success' => false,
        'error' => 'null'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => $votes
    ]);
    exit;
  }
?>
