<?php function getMainPosts() { ?>
  <div class="section-container">
    <div class="section-title">
      Recent Posts
    </div>

    <div class="section-display">
      <?php for ($i=0; $i < 8; $i++) {
        getPost();
      } ?>
    </div>
  </div>
<?php } ?>
