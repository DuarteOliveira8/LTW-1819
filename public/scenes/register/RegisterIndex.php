<link rel="stylesheet" href="/css/scenes/register/RegisterIndex.css">

<?php
include('shared-components/input/Input.php');
include('shared-components/input/DateInput.php');
include('shared-components/Header.php');
include('shared-components/Footer.php');

getHeader();
?>

<div class="container">
  <div class="register-box">

    <div class="registerLogo">
      <a href="/"><img src="/images/webbit-rabbit.png" alt="Webbit logo" height="75px" width="65px"/></a>
    </div>

    <div class="registerWelcome">Create account</div>

    <div class="createAcc">Already have an account? <a href="#">Log in</a>.</div>

    <form method="POST">

      <div class="username">
        <?php input('text', "Username:", "username", "Your username", true); ?>
      </div>

      <div class="first-name">
        <?php input('text', "First name:", "first-name", "Your first name", true); ?>
      </div>

      <div class="last-name">
        <?php input('text', "Last name:", "last-name", "Your last name", true); ?>
      </div>

      <div class="bday">
        <?php dateInput("Birth date:", true); ?>
      </div>

      <div class="email">
        <?php input('email', "Email address:", "email", "Insert your email address", true); ?>
      </div>

      <div class="password">
        <?php input('password', "Password:", "password", "Insert your password", true); ?>
      </div>

      <div class="confirm-password">
        <?php input('password', "Password confirmation:", "confirm-password", "Confirm your password", true); ?>
      </div>

      <div class="submitRegister">
        <button class="submitButton" type="submit">Register</button>
      </div>
    </form>
  </div>
</div>

<?php getFooter(); ?>
