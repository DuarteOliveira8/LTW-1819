<?php
include('templates/shared-components/navbar/navbar-right/LoggedOut.php');
include('templates/shared-components/navbar/navbar-right/LoggedIn.php');
include('templates/shared-components/input/Input.php');
?>

<link rel="stylesheet" href="/css/shared-components/navbar/NavbarIndex.css">

<?php function getNavbar($username, $avatar) { ?>
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
   
    <div class="submit">
      <span class="navbar-link" id="submitButton">Search</span> 
    </div>

    <div class="navbar-right">
      <?php
        if (isset($_SESSION['userID']))
          loggedIn($username, $avatar);
        else
          loggedOut();
      ?>
    </div>
  </div>
<?php } ?>
