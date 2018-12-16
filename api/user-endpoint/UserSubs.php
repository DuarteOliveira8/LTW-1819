<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');
  include_once(__DIR__ . '/../../database/db-access/channel.php');

  if (($user = getUser($matches['username'])) === false) {
    echo json_encode([
      'success' => false,
      'error' => 'username'
    ]);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (($channels = getUserSubscribed(getID($matches['username']))) === false) {
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
  elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    if (($ChannelID = getChannelId($request['Channel'])) === -1) {
      echo json_encode(array('error' => 'Channel does not exist'));
      exit;
    }

    if (isSubscribed($_SESSION['userID'], $ChannelID)) {
      if (($ChannelID = getChannel($request['Channel'])) === -1) {
        echo json_encode(array('error' => 'Channel does not exist'));
      }
      elseif (deleteSubscriber($_SESSION['userID'], $ChannelID) !== -1) {
        echo json_encode(array('success' => 'user_unsubscribed'));
      }
      else {
        echo json_encode(array('error' => 'null'));
      }
    }
    else {
      if (($ChannelID = getChannel($request['Channel'])) === -1) {
        echo json_encode(array('error' => 'Channel does not exist'));
      }
      elseif (insertSubscriber($_SESSION['userID'], $ChannelID) !== -1) {
        echo json_encode(array('success' => 'user_subscribed'));
      }
      else {
        echo json_encode(array('error' => 'null'));
      }
    }
  }
?>
