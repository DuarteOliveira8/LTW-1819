<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');

  if (($channel = getChannelId($matches['channel'])) === -1) {
    echo json_encode([
      'success' => false,
      'error' => 'channel'
    ]);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    if (($posts = getChannelPosts($request['offset'], $channel)) === false) {
      echo json_encode([
        'success' => false,
        'error' => 'null'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => $posts
    ]);
    exit;
  }
?>
