<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');

  if (($channel = getChannel($matches['channel'])) === false) {
    echo json_encode([
      'success' => false,
      'error' => 'channel'
    ]);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode([
      'success' => true,
      'data' => $channel
    ]);
    exit;
  }

?>
