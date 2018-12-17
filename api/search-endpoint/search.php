<?php
  include_once(__DIR__ . '/../../database/db-access/channel.php');
  include_once(__DIR__ . '/../../includes/Session.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($channels = getMatchNameChannel('%' . $matches['search'] . '%')) === false) {
      echo json_encode([
        'success' => false,
        'error' => 'null'
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
