<?php
  include_once(__DIR__ . '/../../includes/Session.php');
  include_once(__DIR__ . '/../../database/db-access/user.php');

  if (!isset($_SESSION['userID'])) {
    echo json_encode(array('error' => 'user_not_logged_in'));
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "string";
    if (($user = getUser($_SESSION['userID'])) == false) {
      echo json_encode(array('error' => 'null'));
    }
    else {
      echo json_encode($user);
    }
  }
  elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = json_decode(file_get_contents('php://input'), true);

    if (!isUsernameValidForUpdate($_SESSION['userID'], $request['Username'])) {
      echo json_encode(array('error' => 'Username is not valid!'));
    }
    elseif (!isEmailValidForUpdate($_SESSION['userID'], $request['Email'])) {
      echo json_encode(array('error' => 'Email is not valid!'));
    }
    elseif (updateUser($_SESSION['userID'], $request['Username'], $request['FirstName'], $request['LastName'], $request['Email'], $request['Bio'], $request['BirthDate'])) {
      if (($user = getUser($_SESSION['userID'])) == false) {
        echo json_encode(array('error' => 'null'));
      }
      else {
        echo json_encode($user);
      }
    }
    else {
      echo json_encode(array('error' => 'null'));
    }
  }
?>
