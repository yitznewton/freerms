<?php if ( ! $referral_note ): ?>
<script type="text/javascript">
  window.location="<?php echo $access_uri ?>";
</script>
<?php endif; ?>

<h1><b><?php echo $title ?></b></h1>

<?php if ( $referral_note ): ?>
  <h2>Important Note:</h2>
  <p><?php echo $referral_note ?></p>
<?php endif; ?>

<p>Please <a href="<?php echo $access_uri ?>">click here</a>
to access <?php echo $title ?>.</p>
