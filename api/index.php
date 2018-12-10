<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if ($request_uri[0][strlen($request_uri[0])-1] == '/')
  $path = substr($request_uri[0], 0, strlen($request_uri[0])-1);
else
  $path = $request_uri[0];

switch ($path) {
  case '/api/user':
    require 'user-endpoint/User.php';
    break;

  case '/api/user/posts':
    require 'user-endpoint/UserPosts.php';
    break;

  case '/api/user/comments':
    require 'user-endpoint/UserComments.php';
    break;

  case '/api/user/subscribed':
    require 'user-endpoint/UserSubs.php';
    break;

  case '/api/user/votes':
    require 'user-endpoint/UserVotes.php';
    break;

  default:
    echo json_encode(array('error' => '404_not_found'));
    break;
}
?>