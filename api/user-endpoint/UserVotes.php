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
    if (($votes = getUserVotes(getID($matches['username']))) == false) {
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
