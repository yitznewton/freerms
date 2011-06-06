<h1>Find Articles</h1>

<h2>Select subject area:</h2>

<form class="form-subject">
  <?php echo $subject_widget->render(
    'subject',
    $subject_default,
    array('id' => 'select-subject')
  ) ?>
  
  <input type="submit" value="Submit" />
</form>

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
  <?php include_partial('databaseListElement', array('er' => $er)) ?>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if ( $featured_dbs ): ?>
<h2>All databases in this subject:</h2>
<?php endif; ?>

<ul>
  <?php foreach ( $databases as $er ): ?>
  <?php include_partial('databaseListElement', array('er' => $er)) ?>
  <?php endforeach; ?>
</ul>
