<h3>Featured</h3>

<ul class="databases featured">
<?php foreach ($databases as $database): ?>
  <?php include_partial('database', array('database' => $database)) ?>
<?php endforeach; ?>
</ul>

