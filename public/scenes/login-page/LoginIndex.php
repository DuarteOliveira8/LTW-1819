<link rel="stylesheet" href="/css/login/login.css">

<?php
include('../../shared-components/input/Input.php');
include('../../shared-components/Header.php');
include('../../shared-components/Footer.php');

getHeader();
?>

<div class="container">
  <div class="login-box">

    <div class="loginLogo">
      <a href="#"><img src="/images/webbit-rabbit.png" alt="Webbit logo" height="75px" width="65px"/></a>
    </div>

    <div class="loginWelcome">Log In</div>

    <div class="createAcc">Don't have an account? <a href="#">Create account</a>.</div>

    <form method="POST">
      <div class="email">
        <?php input('email', "Email address:", "email", "Insert your email address", true); ?>
      </div>

      <div class="password">
        <?php input('password', "Password:", "password", "Insert your password", true); ?>
      </div>

      <div class="submitLogin">
        <button class="submitButton" type="submit">Log In</button>
      </div>
    </form>
  </div>
</div>

<?php getFooter(); ?>
