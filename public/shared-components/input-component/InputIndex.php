<?php function input($type, $title, $placeholder) { ?>
  <div class="inputTitle">
    <?= $title ?>
  </div>

  <input class="input" type="<?php $type ?>" name="email" placeholder="<?= $placeholder ?>" required>
<?php } ?>
