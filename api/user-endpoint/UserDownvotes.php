<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');

  if (($user = getUser($matches['username'])) === false) {
    echo json_encode([
      'success' => false,
      'error' => 'username'
    ]);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($votes = getUserDownvotes($matches['username'])) === false) {
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

    if (hasDownvoted($request['storyId'], $_SESSION['userID'])) {
      if (deleteDownvote($request['storyId'], $_SESSION['userID'])) {
        echo json_encode([
          'success' => true,
          'data' => 'deleted_downvote'
        ]);
        exit;
      }

      echo json_encode([
        'success' => false,
        'error' => 'null'
      ]);
      exit;
    }

    if (insertDownvote($request['storyId'], $_SESSION['userID']) !== -1) {
      echo json_encode([
        'success' => true,
        'data' => 'downvoted'
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
