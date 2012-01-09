<h3>Featured</h3>

<ul class="featured">
<?php foreach ($databases as $database): ?>
  <li><?php echo link_to_database($database->getRawValue()) ?></li>
<?php endforeach; ?>
</ul>

