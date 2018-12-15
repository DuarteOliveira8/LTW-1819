<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');
  include_once(__DIR__ . '/../../database/db-access/comment.php');

  if (($user = getUser($matches['username'])) == false) {
    echo json_encode([
      'success' => false,
      'error' => 'username'
    ]);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($comments = getUserComments($matches['username'])) == false) {
      echo json_encode([
        'success' => false,
        'error' => 'null'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => $comments
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

    if ($request['Story'] !== null) {
      if (getStory($request['Story']) == false) {
        echo json_encode([
          'success' => false,
          'error' => 'story'
        ]);
        exit;
      }
    }
    elseif ($request['Comment'] !== null) {
      if (!getStory($request['Story'])) {
        echo json_encode([
          'success' => false,
          'error' => 'comment'
        ]);
        exit;
      }
    }
    else {
      echo json_encode([
        'success' => false,
        'error' => 'comment_story'
      ]);
      exit;
    }

    if (($commentID = createComment($request['Description'], $request['Date'], $request['Story'], $_SESSION['userID'], $request['Comment'])) !== -1) {
      $comment = getComment($commentID);
      echo json_encode([
        'success' => true,
        'data' => $comment
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
