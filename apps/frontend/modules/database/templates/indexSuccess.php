<?php use_helper('Frontend') ?>

<h2>Databases</h2>

<?php include_partial('subjectWidget', array(
  'widget' => $subjectWidget, 'default' => $subjectDefault)) ?>

<?php include_component('database', 'featuredDatabases',
  array('subject' => $subject, 'libraryIds' => $libraryIds,
    'sf_cache_key' => cache_key($subject, $libraryIds))) ?>

<?php include_component('database', 'databases',
  array('subject' => $subject, 'libraryIds' => $libraryIds,
    'sf_cache_key' => cache_key($subject, $libraryIds))) ?>

