<?php function getChannelBanner($name, $slogan, $subscriptions, $posts, $banner) { ?>
  <div class="banner-container">
    <div class="channel-banner-image" style="background-image: url('/assets/images/channels/<?php echo strip_tags($banner) ?>')"></div>

    <div class="overlay"></div>

    <div class="basic-info">
      <div class="channel-name">
        <?php echo htmlentities($name) ?>
      </div>

      <div class="channel-slogan">
        <?php echo htmlentities($slogan) ?>
      </div>

      <div class="channel-subs">
        <?php echo htmlentities($subscriptions) ?> subscribers
      </div>

      <div class="channel-posts">
        <?php echo htmlentities($posts) ?> posts
      </div>
    </div>

    <button type="button" name="subscribe" class="sub-button">
      Subscribe
    </button>
  </div>
<?php } ?>
