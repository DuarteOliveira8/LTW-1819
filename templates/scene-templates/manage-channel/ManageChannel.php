<?php
  include('templates/shared-components/input/TextArea.php');
?>

<?php function getManageChannel() { ?>
  <div class="container">
    <div class="manage-container">

      <h2 class="manageTitle">Manage Channel</h2>

        <div class="channel-name">
          <?php input('text', "Channel Name:", "username", "Your channel name", true); ?>
        </div>

        <div class="channel-desc">
          <?php input('text',"Channel Description:", "channel-desc","Your channel description", true); ?>
        </div>

        <div class="submitChanges">
          <button class="submitButton" type="submit" id="submitChanges">Save</button>
        </div>
    </div>

    <div class="changeBanner-container">

        <h3 class="bannerPicTitle">Change your channel banner</h3>

        <div class="bannerPic" name="banner" style="background-image: url('/assets/images/channels/default-background.jpg');"></div>

        <div class="submitBanner">
          <button class="submitButton" type="submit">Save</button>
        </div>

    </div>
  </div>
<?php } ?>
