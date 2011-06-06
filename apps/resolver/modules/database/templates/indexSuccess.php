<?php use_helper('Text') ?>

<h1>Available Databases</h1>

<form class="form-subject">
  <?php echo $subject_widget->render(
    'subject',
    $subject_default,
    array('id' => 'select-subject')
  ) ?>
  
  <input type="submit" value="Submit" />
</form>
  
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
