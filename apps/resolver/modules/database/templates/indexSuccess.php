<h1>Find Articles</h1>

<h2>Select subject area:</h2>

<?php include_partial( 'subjectWidget', array(
  'widget' => $subject_widget, 'default' => $subject_default )) ?>

<div class="database-index-intro">
  <p>The following subscribed resources are restricted to the Touro community.
    They can be accessed on-campus from Touro computers, and off-campus with
    a <?php echo link_to('Username & Password', 'http://www.tourolib.org/services/off-campus') ?>.</p>

  <p>Press Ctrl-F to Find a word/phrase on this or other browser pages.</p>
</div>

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

<?php include_partial('list', array('databases' => $databases)) ?>
