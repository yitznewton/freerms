<ul>
  <?php foreach ( $databases as $er ): ?>
  <?php include_partial('listElement', array('er' => $er)) ?>
  <?php endforeach; ?>
</ul>
