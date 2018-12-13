<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($posts = getUserPosts($matches['username'])) == false) {
      echo json_encode([
        'success' => false,
        'error' => 'Username doesn\'t exist'
      ]);
    }
    else {
      echo json_encode($posts);
    }
  }
  elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['userID'])) {
      echo json_encode([
        'success' => false,
        'error' => 'User not logged in'
      ]);
      exit;
    }

    $username = getUsername($_SESSION['userID']);

    $request = json_decode(file_get_contents('php://input'), true);

    if (($ChannelID = getChannel($request['Channel'])) == -1) {
      echo json_encode(array('error' => 'Channel does not exist'));
    }
    elseif (createStory($request['Title'], $request['Description'], $request['Date'], $_SESSION['userID'], $ChannelID) !== -1) {
      echo json_encode(array('success' => 'story_created'));
    }
    else {
      echo json_encode(array('error' => 'null'));
    }
  }
?>
