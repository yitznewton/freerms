<ul class="databases">
<?php foreach ($databases as $database): ?>
  <?php include_partial('database', array('database' => $database)) ?>
<?php endforeach; ?>
</ul>

