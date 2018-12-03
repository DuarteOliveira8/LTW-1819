<link rel="stylesheet" href="/css/shared-components/input/select.css">

<?php function select($title, $name, $required) { ?>
  <div class="selectTitle">
    <?= $title ?>
  </div>


  <?php if ($required): ?>
    <select class="select" name="<?php $name ?>" required>
      <?php for ($i = 1; $i <= 31; $i++): ?>
        <option value="<?= $i ?>"></option>
      <?php endfor; ?>
    </select>

    <select class="select" name="<?php $name ?>" required>
      <?php for ($i = 1; $i <= 12; $i++): ?>
        <option value="<?= $i ?>"></option>
      <?php endfor; ?>
    </select>

    <select class="select" name="<?php $name ?>" required>
      <?php for ($i = 1920; $i <= 2018; $i++): ?>
        <option value="<?= $i ?>"></option>
      <?php endfor; ?>
    </select>
  <?php else: ?>
    <select class="select" name="<?php $name ?>">
      <?php for ($i = 1; $i <= 31; $i++): ?>
        <option value="<?= $i ?>"></option>
      <?php endfor; ?>
    </select>

    <select class="select" name="<?php $name ?>">
      <?php for ($i = 1; $i <= 12; $i++): ?>
        <option value="<?= $i ?>"></option>
      <?php endfor; ?>
    </select>

    <select class="select" name="<?php $name ?>">
      <?php for ($i = 1920; $i <= 2018; $i++): ?>
        <option value="<?= $i ?>"></option>
      <?php endfor; ?>
    </select>
  <?php endif; ?>

<?php } ?>
