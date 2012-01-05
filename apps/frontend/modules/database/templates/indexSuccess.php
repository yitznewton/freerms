<h2>Databases</h2>

<?php include_partial('subjectWidget', array(
  'widget' => $subjectWidget, 'default' => $subjectDefault)) ?>

<?php if ($featuredDatabases->count()): ?>
<?php include_partial('featured', array('databases' => $featuredDatabases)) ?>
<?php endif; ?>

<ul class="databases">
<?php foreach ($databases as $database): ?>
  <li><?php echo link_to_database($database->getRawValue()) ?></li>
<?php endforeach; ?>
</ul>

