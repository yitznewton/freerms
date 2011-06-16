<script type="text/javascript">
  $(document).ready( function() {
    if ( document.getElementById('referral-note') ) {
      // has referral note; should let the user see it
      return;
    }
    
    var thelink = FR.$$('thelink');
    
    if ( ! thelink ) {
      return;
    }
    else if ( navigator.appName == "Microsoft Internet Explorer" ) {
      // hack to get IE to pass Referer URL
      thelink.click();
    }
    else {
      window.location = thelink.href;
    }
  });
</script>

<h1><b><?php echo $title ?></b></h1>

<?php if ( $referral_note ): ?>
  <h2>Important Note:</h2>
  <p id="referral-note"><?php echo $referral_note ?></p>
<?php endif; ?>

<p>Please <a id="thelink" href="<?php echo $access_uri ?>">click here</a>
to access <?php echo $title ?>.</p>
