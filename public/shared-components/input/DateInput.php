<link rel="stylesheet" href="/css/shared-components/input/select.css">

<?php function dateInput($title, $required) { ?>
  <div class="selectTitle">
    <?= $title ?>
  </div>

  <div class="selectChain">
    <?php if ($required): ?>
      <div class="selectInput">
        <select name="day" required>
          <option value="" disabled selected>Day</option>
          <?php for ($i = 1; $i <= 31; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="selectInput">
        <select name="month" required>
          <option value="" disabled selected>Month</option>
          <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="selectInput">
        <select name="year" required>
          <option value="" disabled selected>Year</option>
          <?php for ($i = 1920; $i <= 2018; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
    <?php else: ?>
      <div class="selectInput">
        <select name="day">
          <option value="" disabled selected>Day</option>
          <?php for ($i = 1; $i <= 31; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="selectInput">
        <select name="month">
          <option value="" disabled selected>Month</option>
          <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
            <?= $i ?>
          <?php endfor; ?>
        </select>
      </div>

      <div class="selectInput">
        <select name="year">
          <option value="" disabled selected>Year</option>
          <?php for ($i = 1920; $i <= 2018; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
    <?php endif; ?>
  </div>


<?php } ?>
