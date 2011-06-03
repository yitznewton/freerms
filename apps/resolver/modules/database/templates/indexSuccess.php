<?php use_helper('Text') ?>

<h1>Find Articles</h1>

<h2>Select subject area:</h2>
<select id="db-subject-select" onchange="get_selected_value()" >
  <option value="">All subjects</option>

  <?php foreach ($db_subject_list as $subject): ?>
    <option value="<?php echo $subject->getSlug() ?>"
      <?php if ($selected_subject == $subject->getSlug()): ?>
      selected="selected"
      <?php endif; ?>
      >
      <?php echo $subject->getLabel() ?>
    </option>
  <?php endforeach; ?>

</select>

<div class="database-index-intro">
  <p>The following subscribed resources are restricted to the Touro community.
    They can be accessed on-campus from Touro computers, and off-campus with
    a <?php echo link_to('Username & Password', 'http://www.tourolib.org/services/off-campus') ?>.</p>

  <p>Press Ctrl-F to Find a word/phrase on this or other browser pages.</p>
</div>

<?php if ( $featured_dbs ): ?>
<h2>Featured databases:</h2>
<ul id="featured">
  <?php foreach ( $databases as $er ): ?>
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
