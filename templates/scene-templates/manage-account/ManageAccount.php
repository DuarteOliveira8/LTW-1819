<link rel="stylesheet" href="/css/scenes/manage-account/ManageAccount.css">

<?php
  include('templates/shared-components/input/DateInput.php');
  include('templates/shared-components/input/TextArea.php');
?>

<?php function getManageOptions() { ?>
    <div class="manage-container">

      <h2 class="manageTitle">Manage Account</h2>

      <div class="general-info-form">
        <div class="username" id="username">
          <?php input('text', "Username:", "username", "Your Username", true); ?>
        </div>

        <div class="first-name" id="first-name">
          <?php input('text', "First name:", "first-name", "Your first name", true); ?>
        </div>

        <div class="last-name" id="last-name">
          <?php input('text', "Last name:", "last-name", "Your last name", true); ?>
        </div>

        <div class="user-bio" id="user-bio">
          <?php textarea("Bio:", "user-bio", 20, 50, "Your bio...", true); ?>
        </div>

        <div class="bday" id="bday">
          <?php dateInput("Birth date:", true); ?>
        </div>

        <div class="email" id="email" >
          <?php input('email', "Email address:", "email", "Insert your email address", true); ?>
        </div>

        <div class="submitChanges">
          <button class="submitButton" type="submit" id="submitInfo">Save</button>
        </div>
      </div>

    </div>

    <div class="avatarPassword-container">

      <div class="avatar-container">

          <div class="avatar">

            <h3 class="avatarPicTitle">Change your avatar</h3>

            <div class="avatarPic" name="avatar" style="background-image: url('/assets/images/users/default-profile.png');">
                <input type="file" name="file" id="file"/>
            </div>

          </div>

          <div class="submitAvatar">
            <button class="submitButton" type="submit" id="submitAvatar">Save</button>
          </div>

      </div>

      <div class="password-container">

        <h3 class="passwordTitle">Change your password</h3>

        <div class="current-password">
          <?php input('password', "Current password:", "current-password", "Insert your current password", true); ?>
        </div>

        <div class="new-password">
          <?php input('password', "New password:", "password", "Insert your new password", true); ?>
        </div>

        <div class="confirm-new-password">
          <?php input('password', "New password confirmation:", "confirm-password", "Confirm your password", true); ?>
        </div>

        <div class="submitPassword">
          <button class="submitButton" type="submit" id="submitPassword">Save</button>
        </div>

      </div>

    </div>

<?php } ?>
