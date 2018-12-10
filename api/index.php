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

  default:
    echo "<h1 style='text-align: center; padding-top: 100px;'>404 NOT FOUND</h1>";
    break;
}
?>
