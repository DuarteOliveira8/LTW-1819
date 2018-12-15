<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($channels = getMainChannels()) === false) {
      echo json_encode([
        'success' => false,
        'error' => 'no_channels'
      ]);
      exit;
    }
    
    echo json_encode([
      'success' => true,
      'data' => $channels
    ]);
    exit;
  }
?>
