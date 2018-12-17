<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/comment.php');

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

    if (hasDownvotedComment($request['commentId'], $_SESSION['userID'])) {
      if (deleteDownvoteComment($request['commentId'], $_SESSION['userID'])) {
        $upvoteRatio = getUpvoteRatioComment($request['commentId']);
        echo json_encode([
          'success' => true,
          'data' => [
            'upvoteRatio' => $upvoteRatio,
            'downvoted' => false
          ]
        ]);
        exit;
      }

      echo json_encode([
        'success' => false,
        'error' => 'null'
      ]);
      exit;
    }

    if (insertDownvoteComment($request['commentId'], $_SESSION['userID']) !== -1) {
      $upvoteRatio = getUpvoteRatioComment($request['commentId']);
      echo json_encode([
        'success' => true,
        'data' => [
          'upvoteRatio' => $upvoteRatio,
          'downvoted' => true
        ]
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
