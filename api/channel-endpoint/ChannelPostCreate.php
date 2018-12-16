<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');

  if (($user = getUser($matches['author'])) === false) {
    echo json_encode([
      'success' => false,
      'error' => 'author'
    ]);
    exit;
  }

  if (($channel = getChannelId($matches['channel'])) === -1) {
    echo json_encode([
      'success' => false,
      'error' => 'channel'
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

    if ($_SESSION['userID'].$_SESSION['csrf'] !== getID($matches['author']).$_SERVER['HTTP_CSRF']) {
      echo json_encode([
        'success' => false,
        'error' => 'validation'
      ]);
      exit;
    }

    if (($channelId = getChannelId($request['channel'])) === -1) {
      echo json_encode([
        'success' => false,
        'error' => 'channel'
      ]);
      exit;
    }

    if (createStory($request['title'], $request['description'], $request['date'], $_SESSION['userID'], $channelId) !== -1) {
      echo json_encode([
        'success' => true,
        'data' => 'story_created'
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
