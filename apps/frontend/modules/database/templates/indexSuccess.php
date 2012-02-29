<h2>Databases</h2>

<?php include_partial('subjectWidget', array(
  'widget' => $subjectWidget, 'default' => $subjectDefault)) ?>

<?php include_component('database', 'featuredDatabases',
  array('subject' => $subject, 'libraryIds' => $libraryIds)) ?>

<?php include_component('database', 'databases',
  array('libraryIds' => $libraryIds)) ?>

