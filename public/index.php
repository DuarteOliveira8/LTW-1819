<?php
require __DIR__ . '/../src/Bootstrap.php';

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

switch ($request_uri[0]) {
  case '/':
    require 'scenes/home/HomeIndex.php';
    break;

  case '/login':
    require 'scenes/login/LoginIndex.php';
    break;
}
?>
