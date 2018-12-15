<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($posts = getRecentStories(0)) === false) {
      echo json_encode([
        'success' => false,
        'error' => 'no_posts'
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
