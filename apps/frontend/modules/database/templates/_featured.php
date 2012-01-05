<h3>Featured</h3>

<ul class="featured">
<?php foreach ($databases as $database): ?>
  <li><?php echo link_to($database->getTitle(), 'http://www.google.com/') ?></li>
<?php endforeach; ?>
</ul>

