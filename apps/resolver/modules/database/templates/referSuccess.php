<?php if (! $er->getAccessInfo()->getReferralNote() ): ?>
<script language="JavaScript" type="text/javascript">
<!--
  // redirect for Referer URL authentication
  window.location="<?php echo $access_uri ?>";
//-->
</script>
<?php endif; ?>

<h1><b><?php echo $er->getTitle() ?></b></h1>

<?php if ($er->getAccessInfo()->getReferralNote()): ?>
  <h2>Important Note:</h2>
  <p><?php echo $er->getAccessInfo()->getReferralNote() ?></p>
<?php endif; ?>

<p>Please <a href="<?php echo $access_uri ?>">click here</a>
to access <?php echo $er->getTitle() ?>.</p>
