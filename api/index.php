<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if ($request_uri[0][strlen($request_uri[0])-1] == '/')
  $path = substr($request_uri[0], 0, strlen($request_uri[0])-1);
else
  $path = $request_uri[0];

switch ($path) {
  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)$#', $path, $matches) ? true : false):
    require 'user-endpoint/User.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/posts$#', $path, $matches) ? true : false):
    require 'user-endpoint/UserPosts.php';
    break;

  case '/api/user/comments':
    require 'user-endpoint/UserComments.php';
    break;

  case '/api/user/subscribe':
    require 'user-endpoint/UserSubs.php';
    break;

  case '/api/user/votes':
    require 'user-endpoint/UserVotes.php';
    break;

  case '/api/user/upvotes':
    require 'user-endpoint/UserUpvotes.php';
    break;

  case '/api/user/downvotes':
    require 'user-endpoint/UserDownvotes.php';
    break;

  case '/api/user/password':
    require 'user-endpoint/UserPassword.php';
    break;

  case (preg_match('#^/api/user/(?P<username>[a-zA-Z0-9-_]+)/avatar#', $path, $matches) ? true : false):
    require 'user-endpoint/UserAvatar.php';
    break;

  default:
    echo json_encode(array('error' => '404_not_found'));
    break;
}
?>
