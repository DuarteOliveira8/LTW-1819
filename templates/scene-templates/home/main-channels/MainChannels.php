<?php function getMainChannels() { ?>
  <div class="section-container">
    <div class="section-title">
      Main channels
    </div>

    <div class="section-display">
      <?php for ($i=0; $i < 8; $i++) {
        getChannelComponent();
      } ?>
    </div>
  </div>
<?php } ?>
