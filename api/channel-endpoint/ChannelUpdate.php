<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');

  if (($user = getUser($matches['creator'])) === false) {
    echo json_encode([
      'success' => false,
      'error' => 'username'
    ]);
    exit;
  }

  if (($channelId = getChannelId($matches['channel'])) === -1) {
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

    if ($_SESSION['userID'].$_SESSION['csrf'] !== getID($matches['creator']).$_SERVER['HTTP_CSRF']) {
      echo json_encode([
        'success' => false,
        'error' => 'validation'
      ]);
      exit;
    }

    if (!isUserAuthor($matches['channel'], $_SESSION['userID'])) {
      echo json_encode([
        'success' => false,
        'error' => 'creator'
      ]);
      exit;
    }

    if ($matches['channel'] !== $request['name']) {
      if (!isNameValidForUpdate($request['name'])) {
        echo json_encode([
          'success' => false,
          'error' => 'name'
        ]);
        exit;
      }
    }

    if (updateChannel($channelId, $request['name'], $request['slogan'])) {
      $channel = getChannel($request['name']);
      echo json_encode([
        'success' => true,
        'data' => $channel
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
