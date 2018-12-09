<link rel="stylesheet" href="/css/scenes/home/MainChannels.css">

<?php function getMainChannels() { ?>
  <div class="section-container">
    <div class="section-title">
      Main channels
    </div>

    <div class="channels-display">
      <?php for ($i=0; $i < 8; $i++) {
        getChannelComponent();
      } ?>
    </div>
  </div>
<?php } ?>
