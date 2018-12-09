<link rel="stylesheet" href="/css/scenes/login/login.css">

<?php
  include('templates/shared-components/input/Input.php');
?>

<?php function getLogin() { ?>
  <div class="login-container">
    <div class="login-box">
      <div class="loginLogo">
        <a href="/">
          <img src="/assets/images/webbit-rabbit.png" alt="Webbit logo" height="75px" width="65px"/>
        </a>
      </div>

      <div class="loginWelcome">Log In</div>

      <div class="createAcc">Don't have an account? <a href="/register">Create account</a>.</div>

      <form method="POST" action="actions/auth/Login.php">
        <div class="email">
          <?php input('email', "Email address:", "email", "Insert your email address", true); ?>
        </div>

        <div class="password">
          <?php input('password', "Password:", "password", "Insert your password", true); ?>
        </div>

        <div class="submitLogin">
          <button class="submitButton" type="submit">Log In</button>
        </div>

        <?php if(isset($_SESSION['ERROR'])): ?>
          <div class="form-error">
            <?php echo $_SESSION['ERROR']; ?>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>
<?php } ?>
