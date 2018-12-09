<link rel="stylesheet" href="/css/scenes/channel/CreateChannelIndex.css">

<?php
  include('templates/shared-components/Header.php');
  include('templates/scene-templates/channel/CreateChannel.php');
  include('templates/shared-components/Footer.php');

  getHeader();
?>

<div class="container">
  <?php
    getCreateChannel();
  ?>
</div>

<?php
  getFooter();
?>
