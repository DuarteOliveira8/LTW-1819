<?php function getRules($rules) { ?>
  <div class="rules-container">
    <h1 class="rules-title">Channel rules</h1>

    <?php if (count($rules) == 0): ?>
      <?php echo '<h2>This channel has no rules.</h2>'; ?>
    <?php else: ?>
      <ol class="rule-list">
        <?php foreach ($rules as $rule): ?>
          <li class="rule"><?php echo htmlentities($rule['description']) ?></li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>
  </div>
<?php } ?>
