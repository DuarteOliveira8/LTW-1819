<link rel="stylesheet" href="/css/shared-components/navbar/navbar-right/LoggedIn.css">

<?php function loggedIn() { ?>
  <div class="options-layout" tabIndex="-1" onBlur="hiddenVis()" >
    <div class="triangle-border"></div>
    <div class="triangle"></div>

    <div class="username">
      Username
    </div>

    <hr class='options-line'>

    <div class="options">
      <a class="options-link" href="/profile">
        My profile
      </a>

      <a class="options-link" href="/">
        My channels
      </a>

      <a class="options-link" href="/">
        Manage account
      </a>

      <a class="options-link" href="/">
        Log out
      </a>
    </div>
  </div>

  <div class="user-avatar" style="background-image: url('/assets/images/default-profile.png');"></div>
<?php } ?>
