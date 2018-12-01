<?php
include('navbar-right/LoggedOut.php');
include('navbar-right/LoggedIn.php');
?>

<link rel="stylesheet" href="../../css/navbar/NavbarIndex.css">

<?php function getNavbar() { ?>
  <div class="navbar-container">
    <div class="logo-container">
      <a href="#">
        <img src="../../images/webbit.png" alt="" class="logo">
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
