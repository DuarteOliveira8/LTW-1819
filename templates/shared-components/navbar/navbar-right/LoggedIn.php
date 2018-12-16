<link rel="stylesheet" href="/css/shared-components/navbar/navbar-right/LoggedIn.css">

<?php function loggedIn($username, $avatar) { ?>
  <div class="options-layout" tabindex="-1" hidden>
    <div class="triangle-border"></div>
    <div class="triangle"></div>

    <div class="username">
      <?php echo strip_tags($username) ?>
    </div>

    <hr class='options-line'>

    <div class="options">
      <div class="options-link" onclick="location.href='/profile/<?php echo strip_tags($username) ?>'">
        My profile
      </div>

      <div class="options-link" onclick="location.href='/my-channels'">
        My channels
      </div>

      <div class="options-link" onclick="location.href='/manage-account'">
        Manage account
      </div>

      <div class="options-link" onclick="location.href='/actions/auth/Logout.php'">
        Log out
      </div>
    </div>
  </div>

  <div class="user-avatar" style="background-image: url('/assets/images/users/<?php echo strip_tags($avatar) ?>');"></div>

  <script type="text/javascript" src="/js/shared-components/Navbar.js"></script>
<?php } ?>
