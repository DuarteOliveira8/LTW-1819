<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/story.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    if (($posts = getRecentStories($request['offset'])) === false) {
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
