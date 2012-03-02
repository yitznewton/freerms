  <li>
    <?php echo link_to_database($database->getRawValue()) ?>

    <?php if ($database->getDescription()): ?>
      <img class="info-icon" src="<?php echo public_path('/images/i.png') ?>"
        alt="Information icon" />
      <span class="sep">&ndash;</span>
      <span class="description">
        <?php echo $database->getDescription() ?>
      </span>
    <?php endif; ?>

    <?php if ($database->getPublicNote()): ?>
      <div class="public-note"><?php echo $database->getPublicNote() ?></div>
    <?php endif; ?>

    <?php if ($database->getIsUnavailable()): ?>
      <div class="unavailable-note">This database is currently unavailable.</div>
    <?php endif; ?>
  </li>

