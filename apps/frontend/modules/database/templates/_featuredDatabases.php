<?php if ($featuredDatabases->count()): ?>
<h3>Featured</h3>

<ul class="databases featured">
<?php foreach ($featuredDatabases as $database): ?>
  <?php include_partial('database', array('database' => $database)) ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>

