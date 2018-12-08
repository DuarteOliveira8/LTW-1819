<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if ($request_uri[0][strlen($request_uri[0])-1] == '/')
  $path = substr($request_uri[0], 0, strlen($request_uri[0])-1);
else
  $path = $request_uri[0];

switch ($path) {
  case '':
    require 'scenes/home/HomeIndex.php';
    break;

  case '/login':
    require 'scenes/login/LoginIndex.php';
    break;

  case '/profile':
    require 'scenes/profile/ProfileIndex.php';
    break;

  case '/register':
    require 'scenes/register/RegisterIndex.php';
    break;

  case '/channel':
    require 'scenes/channel/ChannelIndex.php';
    break;

  default:
    echo "<h1 style='text-align: center; padding-top: 100px;'>404 NOT FOUND</h1>";
    break;
}
?>
