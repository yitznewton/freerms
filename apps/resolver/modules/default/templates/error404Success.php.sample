<h2>Error</h2>

<p>We're sorry,
<?php echo sfConfig::get('app_local-erms-name', 'we') ?> 
could not locate the page you requested.  Please back up and try again.</p>

<p>If the problem persists, please contact user support at

<?php 
$email = sfConfig::get(
  'app_support-email',
  'webmaster@'.$_SERVER['SERVER_NAME']
);

echo mail_to($email)
?>.</p>
