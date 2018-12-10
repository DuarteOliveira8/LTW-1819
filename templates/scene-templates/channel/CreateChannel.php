<link rel="stylesheet" href="/css/scenes/channel/CreateChannel.css">

<?php function getCreateChannel() { ?>
    <div class="create-box">

      <div class="webbitLogo">
        <a href="/">
          <img src="/assets/images/webbit-rabbit.png" alt="Webbit logo" height="75px" width="65px"/>
        </a>
      </div>

      <div class="windowLabel">Create a channel</div>

      <form method="POST">

        <div class="channel-name">
          <?php input('text', "Channel Name:", "channel-name", "Channel Name", true); ?>
        </div>

        <div class="channel-description">
          <?php input('text', "Channel Description:", "channel-description", "Channel Description", true); ?>
        </div>

        <div class="submitChannel">
          <button class="submitButton" type="submit">Start</button>
        </div>
      </form>
    </div>
<?php } ?>
