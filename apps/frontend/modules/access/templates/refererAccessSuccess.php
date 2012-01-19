<?php if ($referralNote): ?>
<p class="referral-note"><?php echo $referralNote ?></p>
<p><?php echo link_to('Click here to access ' . $databaseTitle, $databaseUrl,
  array('class' => 'database-link')) ?>.
</p>

<?php else: ?>
<div id="refer-noscript">
  <p><?php echo link_to('Click here to access ' . $databaseTitle, $databaseUrl,
    array('class' => 'database-link',
          'id' => 'database-link-automatic')) ?>.
  </p>
</div>

<div id="refer-withscript">
  <p>Loading...</p>
</div>

<script type="text/javascript">
  document.getElementById('refer-noscript').style.display = 'none';
  document.getElementById('refer-withscript').style.display = 'block';

  if (
    /MSIE (\d+\.\d+);/.test(navigator.userAgent)
    && new Number(RegExp.$1) < 9
  ) {
    // IE<9 does not pass referer on window.location.replace(); back button
    // will not work
    document.getElementById('database-link-automatic').click();
  }
  else {
    window.location.replace(
      document.getElementById('database-link-automatic'));
  }
</script>

<?php endif; ?>

