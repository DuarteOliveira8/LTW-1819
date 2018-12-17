<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/comment.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($comment = getComment($matches['id'])) === false) {
      echo json_encode([
        'success' => false,
        'error' => 'id'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => $comment
    ]);
    exit;
  }
?>
