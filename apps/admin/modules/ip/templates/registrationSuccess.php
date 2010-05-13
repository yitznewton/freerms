<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li><?php echo link_to('IP Ranges', 'ip/index') ?> ></li>
  <li>Registration</li>
</ul>

<?php if ( $auto_email ): ?>
<h2>Automatic email notification</h2>
<p>There are unregistered IP ranges eligible for automatic update.
  <?php var_dump($auto_email) ?>
  <?php //echo link_to( 'Click here to auto-update.', 'ip/autoupdate', array( 'confirm' => 'This will send email to vendors.' ) ) ?>
</p>
<?php endif; ?>

<?php if ( $all ): ?>
<h2>Manual vendor notification</h2>
<p>The following ranges are unregistered:</p>
  <?php if ( $email_manual ): ?>
    <?php foreach ( $email_manual as $contact ): ?>

    <?php endforeach; ?>
  <?php endif; ?>
  <?php if ( $phone ): ?>
    <?php foreach ( $phone as $contact ): ?>

    <?php endforeach; ?>
  <?php endif; ?>
  <?php if ( $web_contact ): ?>
    <?php foreach ( $web_contact as $organization ): ?>

    <?php endforeach; ?>
  <?php endif; ?>
  <?php if ( $web_admin ): ?>
    <?php foreach ( $web_admin as $organization ): ?>

    <?php endforeach; ?>
  <?php endif; ?>

<?php else: ?>
<p>There are no unregistered IP ranges.</p>
<?php endif; ?>
