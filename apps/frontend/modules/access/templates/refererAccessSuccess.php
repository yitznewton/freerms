<?php if ($referralNote): ?>
<p class="referral-note"><?php echo $referralNote ?></p>
<p><?php echo link_to('Click here to access ' . $databaseTitle, $databaseUrl,
  array('class' => 'referral-link')) ?>.
</p>
<?php endif; ?>

