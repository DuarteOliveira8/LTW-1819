<link rel="stylesheet" href="/css/shared-components/navbar/NavbarIndex.css">

<?php
include('templates/shared-components/navbar/navbar-right/LoggedOut.php');
include('templates/shared-components/navbar/navbar-right/LoggedIn.php');
include('templates/shared-components/input/Input.php');
?>

<?php function getNavbar() { ?>
  <div class="navbar-container">
    <a href="/">
      <div class="logo-container">
        <img src="/assets/images/webbit-name.png" alt="" class="logo-name">
        <img src="/assets/images/webbit-rabbit.png" alt="" class="logo-rabbit">
      </div>
    </a>

    <div class="search">
      <?php input('text', "", "search", "Search...", false); ?>
    </div>

    <div class="navbar-right">
      <?php
        if (isset($_SESSION['userID']))
          loggedIn();
        else
          loggedOut();
      ?>
    </div>
  </div>
<?php } ?>
