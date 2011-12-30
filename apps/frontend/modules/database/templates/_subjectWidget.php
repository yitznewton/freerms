<?php if (count($widget->getChoices()) > 1): ?>
  <form class="subject-widget">
    <?php echo $widget->render(
      'subject',
      $default,
      array('id' => 'subject-select'),
      ESC_RAW
    ) ?>

    <input type="submit" value="Submit" />
  </form>
<?php endif; ?>

