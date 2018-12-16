<?php
  include_once('includes/Session.php');
  include_once('database/db-access/channel.php');
  include_once('templates/shared-components/Header.php');
  include_once('templates/shared-components/navbar/NavbarIndex.php');
  include_once('templates/scene-templates/channel/Banner.php');
  include_once('templates/scene-templates/channel/RecentPosts.php');
  include_once('templates/scene-templates/channel/Rules.php');
  include_once('templates/shared-components/Footer.php');

  if (($channel = getChannel($matches['channel'])) === false) {
    die(header('Location: /404'));
  }

  $rules = getChannelRules($channel['id']);

  getHeader();
  getNavbar($user['username'], $user['avatar']);
?>

<link rel="stylesheet" href="/css/scenes/channel/ChannelIndex.css">

<div class="channel-container">
  <?php
    getChannelBanner($channel['name'], $channel['slogan'], $channel['subscriptions'], $channel['posts'], $channel['banner']);
  ?>

  <div class="content">
    <?php
      getRecentPosts();
      getRules($rules);
    ?>
  </div>
</div>

<script type="module" src="/js/scenes/channel/Channel.js"></script>

<?php getFooter(); ?>
