<?php if ( count( $widget->getChoices() ) > 1 ): ?>

<form class="form-subject">
  <?php echo $widget->render(
    'subject',
    $default,
    array('id' => 'select-subject')
  ) ?>
  
  <input type="submit" value="Submit" />
</form>

<?php endif; ?>