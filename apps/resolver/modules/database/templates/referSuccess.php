<h1><b><?php echo $title ?></b></h1>

<?php if ( $referral_note ): ?>
  <h2>Important Note:</h2>
  <p id="referral-note"><?php echo $referral_note ?></p>
<?php endif; ?>

<p id="referral-link-instruction">Please
<a id="referral-link" href="<?php echo $access_uri ?>">click here</a>
to access <?php echo $title ?>.</p>
