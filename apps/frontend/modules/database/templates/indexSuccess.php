<h2>Databases</h2>

<?php include_partial('subjectWidget', array(
  'widget' => $subjectWidget, 'default' => $subjectDefault)) ?>

<?php if ($featuredDatabases->count()): ?>
<?php include_partial('featured', array('databases' => $featuredDatabases)) ?>
<?php endif; ?>

