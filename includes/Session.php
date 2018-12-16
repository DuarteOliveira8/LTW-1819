<?php
  session_start();

  function generate_random_token() {
    return bin2hex(openssl_random_pseudo_bytes(32));
  }

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }

  include_once(__DIR__ . '/../database/db-access/user.php');

  if (isset($_SESSION['userID'])) {
    $user = getUser($_SESSION['username']);
  }
?>
