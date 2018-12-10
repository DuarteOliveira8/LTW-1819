<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if ($request_uri[0][strlen($request_uri[0])-1] == '/')
  $path = substr($request_uri[0], 0, strlen($request_uri[0])-1);
else
  $path = $request_uri[0];

switch ($path) {
  case '':
    require './scenes/HomeIndex.php';
    break;

  case '/login':
    require 'scenes/LoginIndex.php';
    break;

  case '/profile':
    require 'scenes/ProfileIndex.php';
    break;

  case '/register':
    require 'scenes/RegisterIndex.php';
    break;

  case '/post':
    require 'scenes/PostIndex.php';
    break;

  case '/channel':
    require 'scenes/ChannelIndex.php';
    break;

  case '/create-channel':
    require 'scenes/CreateChannelIndex.php';
    break;

  case '/create-post':
    require 'scenes/CreatePostIndex.php';
    break;

  case '/manage-account':
    require 'scenes/ManageAccountIndex.php';
    break;

  default:
    echo "<h1 style='text-align: center; padding-top: 100px;'>404 NOT FOUND</h1>";
    break;
}
?>
