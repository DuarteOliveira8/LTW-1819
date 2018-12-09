<link rel="stylesheet" href="/css/shared-components/navbar/navbar-right/LoggedIn.css">

<?php function loggedIn() { ?>
  <div class="options-layout" tabindex="-1" hidden>
    <div class="triangle-border"></div>
    <div class="triangle"></div>

    <div class="username">
      Username
    </div>

    <hr class='options-line'>

    <div class="options">
      <div class="options-link" onclick="location.href='/profile'">
        My profile
      </div>

      <div class="options-link" onclick="location.href='/'">
        My channels
      </div>

      <div class="options-link" onclick="location.href='/'">
        Manage account
      </div>

      <div class="options-link" onclick="location.href='/actions/auth/Logout.php'">
        Log out
      </div>
    </div>
  </div>

  <div class="user-avatar" style="background-image: url('/assets/images/default-profile.png');"></div>

  <script type="text/javascript" src="/js/shared-components/Navbar.js"></script>
<?php } ?>
