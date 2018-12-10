<link rel="stylesheet" href="/css/shared-components/input/text-area.css">

<?php function textarea($title, $name, $rows, $cols, $placeholder, $required) { ?>
  <?php if ($title != "") { ?>
    <div class="textareaTitle">
      <?= $title ?>
    </div>
  <?php } ?>

  <?php if ($required): ?>
    <textarea class="text-area" rows="<?= $rows ?>" cols="<?= $cols ?>" name="<?= $name ?>" placeholder="<?= $placeholder ?>" required></textarea>
  <?php else: ?>
    <textarea class="text-area" rows="<?= $rows ?>" cols="<?= $cols ?>" name="<?= $name ?>" placeholder="<?= $placeholder ?>"></textarea>
  <?php endif; ?>
<?php } ?>
