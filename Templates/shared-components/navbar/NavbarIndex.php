<?php
include('navbar-right/LoggedOut.php');
include('navbar-right/LoggedIn.php');
?>

<link rel="stylesheet" href="../assets/css/navbar/NavbarIndex.css">

<?php function navbar() { ?>
  <div class="navbar-container">
    <div class="logo-container">
      <a href="#">
        <img src="../assets/images/webbit.png" alt="" class="logo">
      </a>
    </div>

    <div class="search">
      <input type="text" placeholder="Search..." class="search-input">
    </div>

    <div class="navbar-right">
      <?php loggedOut() ?>
    </div>
  </div>
<?php } ?>
