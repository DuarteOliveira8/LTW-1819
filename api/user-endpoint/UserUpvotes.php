<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');

  if (!isset($_SESSION['userID'])) {
    echo json_encode(array('error' => 'user_not_logged_in'));
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($votes = getUserUpvotes($_SESSION['userID'])) === false) {
      echo json_encode(array('error' => 'null'));
    }
    else {
      echo json_encode($votes);
    }
  }
  elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    if (hasUpvoted($request['StoryID'], $_SESSION['userID'])) {
      if (deleteUpvote($request['StoryID'], $_SESSION['userID'])) {
        echo json_encode(array('success' => 'deleted_upvote'));
      }
      else {
        echo json_encode(array('error' => 'null'));
      }
    }
    else {
      if (insertUpvote($request['StoryID'], $_SESSION['userID']) !== -1) {
        echo json_encode(array('success' => 'upvoted'));
      }
      else {
        echo json_encode(array('error' => 'null'));
      }
    }
  }
?>
