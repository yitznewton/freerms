<?php use_helper('PagerNavigation') ?>

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

<form>
<select id="dbsubject" onchange="get_selected_value()"
name="subject">
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
<input id="subject-submit" type="submit" value="Go">
</form>

<script type="text/javascript">
  document.getElementById('subject-submit').style.display = 'none';
</script>

<p>The following subscribed resources are
restricted to the Touro community.  They can be accessed on-campus from
Touro computers, and off-campus with a
<a href="http://www.touro.edu/library/Forms/Login&Password.asp">
Username & Password</a>.

<p>Press Ctrl-F to Find a word/phrase on this or other browser pages.</p>

<hr>

<div class="pager"><?php //echo pager_navigation($pager, 'database/index?subject='.$selected_subject.'&page=', 10) ?></div>

<ul>

  <?php //foreach ($pager->getResults() as $er): ?>
  <?php foreach ($databases as $er): ?>

  <li id="database-listing-<?php echo $er->getId() ?>">
    <span class="database-title">
      <?php if (!$er->getProductUnavailable()): ?>
        <?php echo link_to($er->getTitle(), $er->getUserURL()) ?> -
      <?php else: ?>
        <strong><?php echo $er->getTitle() ?></strong> -
      <?php endif; ?>
    </span>

    <span class="database-description-short">
      <?php if ( strlen( $er->getDescription() ) > 110 ): ?>
        <?php echo substr( $er->getDescription(), 0, 100 ) ?>...
          <a href="#" class="description-link">[full description]</a>
      <?php else: ?>
        <?php echo $er->getDescription() ?>
      <?php endif; ?>
    </span>

    <span class="database-description-full" style="display:none;">
      <?php echo $er->getDescription() ?>
    </span>

    <?php if ($er->getProductUnavailable()): ?>
      <div class="product-unavailable"></div>
    <?php endif; ?>

    <?php if ($er->getPublicNote()): ?>
      <div class="product-note">
        <?php echo $er->getPublicNote() ?>
      </div>
    <?php endif; ?>
  </li>

  <?php endforeach; ?>

</ul>

<div class="pager"><?php //echo pager_navigation($pager, 'database/index?subject='.$selected_subject.'&page=', 10) ?></div>

