<link rel="stylesheet" href="/css/shared-components/navbar/NavbarIndex.css">

<?php
include('shared-components/navbar/navbar-right/LoggedOut.php');
include('shared-components/navbar/navbar-right/LoggedIn.php');
include('shared-components/input/Input.php');
?>

<?php function getNavbar() { ?>
  <div class="navbar-container">
    <a href="/">
      <div class="logo-container">
        <img src="/images/webbit-name.png" alt="" class="logo-name">
        <img src="/images/webbit-rabbit.png" alt="" class="logo-rabbit">
      </div>
    </a>

    <div class="search">
      <?php input('text', "", "search", "Search...", false); ?>
    </div>

    <div class="navbar-right">
      <?php loggedOut() ?>
    </div>
  </div>
<?php } ?>
