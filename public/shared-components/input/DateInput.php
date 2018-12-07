<link rel="stylesheet" href="/css/shared-components/input/select.css">

<?php function dateInput($title, $name, $required) { ?>
  <div class="selectTitle">
    <?= $title ?>
  </div>

  <div class="selectChain">
    <?php if ($required): ?>
      <select class="selectDay" name="<?php $name ?>" required>
        <?php for ($i = 1; $i <= 31; $i++): ?>
          <option value="<?= $i ?>"></option>
        <?php endfor; ?>
      </select>

      <select class="selectMonth" name="<?php $name ?>" required>
        <?php for ($i = 1; $i <= 12; $i++): ?>
          <option value="<?= $i ?>"></option>
        <?php endfor; ?>
      </select>

      <select class="selectYear" name="<?php $name ?>" required>
        <?php for ($i = 1920; $i <= 2018; $i++): ?>
          <option value="<?= $i ?>"></option>
        <?php endfor; ?>
      </select>
    <?php else: ?>
      <select class="selectDay" name="<?php $name ?>">
        <?php for ($i = 1; $i <= 31; $i++): ?>
          <option value="<?= $i ?>"></option>
        <?php endfor; ?>
      </select>

      <select class="selectMonth" name="<?php $name ?>">
        <?php for ($i = 1; $i <= 12; $i++): ?>
          <option value="<?= $i ?>"></option>
          <?= $i ?>
        <?php endfor; ?>
      </select>

      <select class="selectYear" name="<?php $name ?>">
        <?php for ($i = 1920; $i <= 2018; $i++): ?>
          <option value="<?= $i ?>"></option>
        <?php endfor; ?>
      </select>
    <?php endif; ?>
  </div>


<?php } ?>
