<link rel="stylesheet" href="/css/shared-components/input/input.css">

<?php function input($type, $title, $name, $placeholder, $required) { ?>
  <div class="inputTitle">
    <?= $title ?>
  </div>

  <?php if ($required): ?>
    <input class="input" type="<?php $type ?>" name="<?php $name ?>" placeholder="<?= $placeholder ?>" required>
  <?php else: ?>
    <input class="input" type="<?php $type ?>" name="<?php $name ?>" placeholder="<?= $placeholder ?>">
  <?php endif; ?>
<?php } ?>
