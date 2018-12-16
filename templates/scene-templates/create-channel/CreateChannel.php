<?php function getCreateChannel() { ?>
  <div class="container">
    <div class="create-box">

      <div class="webbitLogo">
        <a href="/">
          <img src="/assets/images/webbit-rabbit.png" alt="Webbit logo" height="75px" width="65px"/>
        </a>
      </div>

      <div class="windowLabel">Create a channel</div>

      <div class="channel-name">
        <?php input('text', "Channel Name:", "channel-name", "Channel Name", true); ?>
      </div>

      <div class="channel-description">
        <?php input('text', "Channel Slogan:", "channel-slogan", "Channel Slogan", true); ?>
      </div>

      <div class="submitChannel" id="submitButton">
        <button class="submitButton" type="submit">Start</button>
      </div>

    </div>
  </div>
<?php } ?>
