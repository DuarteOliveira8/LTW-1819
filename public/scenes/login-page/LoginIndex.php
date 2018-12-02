<?php include('../../shared-components/input/Input.php') ?>
<link rel="stylesheet" href="/css/login/login.css">

<div class="container">
  <div class="login-box">

    <div class="loginLogo">
      <img src="/images/webbit.png" alt="Webbit logo" height="75px" width="75px"/>
    </div>

    <div class="loginWelcome">Log In</div>

    <div class="createAcc">Don't have an account? <a href="#">Create account</a>.</div>

    <div class="email">
      <?php input('email', "Email address:", "email", "Insert your email address", true); ?>
    </div>

    <div class="password">
      <?php input('password', "Password:", "password", "Insert your password", true); ?>
    </div>

    <div class="submitLogin">
      <button class="submitButton" type="submit">Log In </button>
    </div>

    </div>

  </div>
</div>
