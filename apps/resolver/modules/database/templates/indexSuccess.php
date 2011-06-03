<script type="text/javascript">
  function get_selected_value()
  {
    var selected_value = document.getElementById("dbsubject").value;
    var url = window.location.protocol + '//'
            + window.location.host
            + window.location.pathname + '?subject=';
    window.location.href = url + selected_value;
  }
</script>

<?php use_helper('Text') ?>

<h1>Available Databases</h1>

<select id="dbsubject" onchange="get_selected_value()" >
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
