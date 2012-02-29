<h2>Databases</h2>

<?php include_partial('subjectWidget', array(
  'widget' => $subjectWidget, 'default' => $subjectDefault)) ?>

<?php if ($featuredDatabases->count()): ?>
<?php include_partial('featured', array('databases' => $featuredDatabases)) ?>
<?php endif; ?>

<ul class="databases">
<?php foreach ($databases as $database): ?>
  <?php include_partial('database', array('database' => $database)) ?>
<?php endforeach; ?>
</ul>

