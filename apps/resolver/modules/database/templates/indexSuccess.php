<h1>Available Databases</h1>

<?php include_partial( 'subjectWidget', array(
  'widget' => $subject_widget, 'default' => $subject_default )) ?>

<?php if ( $featured_dbs ): ?>
<h2>Featured databases:</h2>
<ul id="featured">
  <?php foreach ( $featured_dbs as $er ): ?>
  <?php include_partial('listElement', array('er' => $er)) ?>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if ( $subject && $featured_dbs ): ?>
<h2>All databases in this subject:</h2>
<?php elseif ( $featured_dbs ): ?>
<h2>All databases:</h2>
<?php endif; ?>

<?php // separate partial in order to enable caching ?>
<?php include_partial('list', array('databases' => $databases)) ?>
