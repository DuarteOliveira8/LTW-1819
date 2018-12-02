<?php
include('navbar-right/LoggedOut.php');
include('navbar-right/LoggedIn.php');
?>

<link rel="stylesheet" href="/css/navbar/NavbarIndex.css">

<?php function getNavbar() { ?>
  <div class="navbar-container">
    <a href="#">
      <div class="logo-container">
        <img src="/images/webbit-name.png" alt="" class="logo-name">
        <img src="/images/webbit-rabbit.png" alt="" class="logo-rabbit">
      </div>
    </a>

    <div class="search">
      <input type="text" placeholder="Search..." class="search-input">
    </div>

    <div class="navbar-right">
      <?php loggedOut() ?>
    </div>
  </div>
<?php } ?>
