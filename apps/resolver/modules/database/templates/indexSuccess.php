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

<h1>Find Articles</h1>


<h2>Select subject area:</h2>
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

<div class="database-index-intro">
  <p>The following subscribed resources are restricted to the Touro community.
    They can be accessed on-campus from Touro computers, and off-campus with
    a <?php echo link_to('Username & Password', 'http://www.tourolib.org/services/off-campus') ?>.</p>

  <p>Press Ctrl-F to Find a word/phrase on this or other browser pages.</p>
</div>

<?php if ($featured_dbs): ?>
<h2>Featured databases:</h2>
<ul id="featured">
  <?php foreach ($featured_dbs as $er): ?>
   <li>
     <?php echo link_to($er->getTitle(), 'database/access?id='.$er->getId()) ?> -
 	<?php echo $er->getDescription() ?>
  </li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if ($featured_dbs): ?>
<h2>All databases in this subject:</h2>
<?php endif; ?>
<ul>
  <?php foreach ($databases as $er): ?>
  <li>
    <?php echo link_to($er->getTitle(), 'database/access?id='.$er->getId()) ?> -
	<?php echo $er->getDescription() ?>

	<?php if ($er->getPublicNote()): ?>
	  <div class="product-note"><?php echo $er->getPublicNote() ?></div>
	<?php endif; ?>

	<?php if ($er->getProductUnavailable()): ?>
	  <div class="product-unavailable"><?php echo $er->getProductUnavailable() ?></div>
	<?php endif; ?>
  </li>
  <?php endforeach; ?>
 </ul>
