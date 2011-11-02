<?php use_helper('Text') ?>

<li>
  <?php echo link_to($er->getTitle(), 'database/access?id='.$er->getId()) ?>

  <span class="description-container">
    <span class="description-icon">
      <img src="/images/i.png" alt="information icon" />
    </span>
    <span class="description-text"><?php echo $er->getDescription() ?></span>
  </span>

  <?php if ( $er->getPublicNote() ): ?>
  <div class="product-note"><?php echo $er->getPublicNote() ?></div>
  <?php endif; ?>
</li>
