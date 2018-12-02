<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

switch ($request_uri[0]) {
  case '/':
    require 'scenes/home/HomeIndex.php';
    break;

  case '/login':
    require 'scenes/login/LoginIndex.php';
    break;

  case '/login/':
    require 'scenes/login/LoginIndex.php';
    break;

  case '/profile':
    require 'scenes/profile/ProfileIndex.php';
    break;

  case '/profile/':
    require 'scenes/profile/ProfileIndex.php';
    break;

  default:
    echo "<h1 style='text-align: center; padding-top: 100px;'>404 NOT FOUND</h1>";
    break;
}
?>
