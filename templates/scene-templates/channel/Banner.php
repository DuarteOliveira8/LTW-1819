<?php function getChannelBanner($name, $slogan, $subscriptions, $posts, $banner) { ?>
  <div class="banner-container">
    <div class="channel-banner-image" style="background-image: url('/assets/images/channels/<?php echo strip_tags($banner) ?>')"></div>

    <div class="overlay"></div>

    <div class="basic-info">
      <div class="channel-name">
        <?php echo strip_tags($name) ?>
      </div>

      <div class="channel-slogan">
        <?php echo strip_tags($slogan) ?>
      </div>

      <div class="channel-subs">
        <?php echo strip_tags($subscriptions) ?> subscribers
      </div>

      <div class="channel-posts">
        <?php echo strip_tags($posts) ?> posts
      </div>
    </div>

    <button type="button" name="subscribe" class="sub-button">
      Subscribe
    </button>
  </div>
<?php } ?>
