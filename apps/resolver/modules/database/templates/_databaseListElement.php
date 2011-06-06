<?php use_helper('Text') ?>

<li>
  <?php echo link_to($er->getTitle(), 'database/access?id='.$er->getId()) ?> -

  <?php if ( strlen( $er->getDescription() ) > 220 ): ?>
  <span class="description-short">
    <?php echo truncate_text( $er->getDescription(), 200 ) ?>
    [<a href="#" class="show-more" >show more</a>]
  </span>
  <span class="description-full">
    <?php echo $er->getDescription() ?>
  </span>

  <?php else: ?>
  <?php echo $er->getDescription() ?>

  <?php endif; ?>


  <?php if ( $er->getPublicNote() ): ?>
  <div class="product-note"><?php echo $er->getPublicNote() ?></div>
  <?php endif; ?>

  <?php if ( $er->getProductUnavailable() ): ?>
  <div class="product-unavailable"><?php echo $er->getProductUnavailable() ?></div>
  <?php endif; ?>
</li>
