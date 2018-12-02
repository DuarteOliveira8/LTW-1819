<?php include('../../shared-components/input-component/InputIndex.php') ?>
<link rel="stylesheet" href="/css/login/login.css">
<link rel="stylesheet" href="/css/input/input.css">

<div class="container">
  <div class="login-box">

    <div class="loginLogo">
      <img src="/images/webbit.png" alt="Webbit logo" height="75px" width="75px"/>
    </div>

    <div class="loginWelcome">Log In</div>

    <div class="createAcc">Don't have an account? <a href="#">Create account</a>.</div>

    <div class="email">
      <?php input('email', "Email address:", "Insert your email address"); ?>
    </div>

    <div class="password">
      <?php input('password', "Password:", "Insert your password"); ?>
    </div>

    <div class="submitLogin">
      <button class="submitButton" type="submit">Log In </button>
    </div>

    </div>

  </div>
</div>
