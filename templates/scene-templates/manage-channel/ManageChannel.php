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
          <?php textarea("Channel Description:", "channel-desc", 20, 50, "Your channel description", true); ?>
        </div>

        <div class="submitChanges">
          <button class="submitButton" type="submit">Save</button>
        </div>
    </div>

    <div class="changeBanner-container">

        <h3 class="bannerPicTitle">Change your channel banner</h3>

        <div class="bannerPic" style="background-image: url('/assets/images/spaghetti.jpg');"></div>

        <div class="submitBanner">
          <button class="submitButton" type="submit">Save</button>
        </div>

    </div>
  </div>
<?php } ?>
