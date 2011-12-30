<?php if (count($widget->getChoices()) > 1): ?>
<form class="subject-widget">
  <?php echo $widget->render(
    'subject',
    $default,
    array('id' => 'subject-select')
  ) ?>
</form>
<?php endif; ?>

