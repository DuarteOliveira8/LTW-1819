<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');

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

    if (hasUpvoted($request['postId'], $_SESSION['userID'])) {
      echo json_encode([
        'success' => true,
        'data' => 'upvoted'
      ]);
      exit;
    }

    if (hasDownvoted($request['postId'], $_SESSION['userID'])) {
      echo json_encode([
        'success' => true,
        'data' => 'downvoted'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => 'null'
    ]);
    exit;
  }
?>
