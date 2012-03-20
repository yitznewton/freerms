<h2>Databases</h2>

<img class="info" src="<?php echo public_path('/images/i.png') ?>"
  alt="Information icon" />

<?php include_partial('subjectWidget', array(
  'widget' => $subjectWidget, 'default' => $subjectDefault)) ?>

<?php include_component('database', 'featuredDatabases',
  array('subject' => $subject, 'libraryIds' => $libraryIds)) ?>

<?php include_component('database', 'databases',
  array('subject' => $subject, 'libraryIds' => $libraryIds)) ?>

