<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li><?php echo link_to('IP Ranges', 'ip/index') ?> ></li>
  <li>Registration</li>
</ul>

<?php if ( $auto_email ): ?>
<h2>Automatic registration</h2>
<p>There are IP ranges eligible for automatic registration to selected
  vendors via email.</p>

<ul>
  <?php foreach ( $auto_email as $ip_reg_event ): ?>
    <li><?php echo $ip_reg_event ?></li>
  <?php endforeach; ?>
</ul>

<p><?php echo link_to( 'Click here to auto-update.', 'ip/autoregister', array( 'confirm' => 'This will send email to vendors.' ) ) ?></p>

<?php endif; ?>

<?php if ( $manual_email_array ): ?>
  <h2>Manual email registration</h2>

  <ul>
  <?php foreach ( $manual_email_array as $contact_array ): ?>
    <li>
      <div>
        <div><?php echo link_to( $contact_array['contact']->getFirstName() . ' ' . $contact_array['contact']->getLastName(), 'contact/edit?id=' . $contact_array['contact']->getId() ) ?></div>
        <div><?php echo mail_to( $contact_array['contact']->getEmail() ) ?></div>
      </div>
      <ul>
        <?php foreach ( $contact_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?></li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( $phone ): ?>
  <h2>Phone registration</h2>

  <ul>
  <?php foreach ( $phone as $contact_array ): ?>
    <li>
      <div>
        <div><?php echo link_to( $contact_array['contact']->getFirstName() . ' ' . $contact_array['contact']->getLastName(), 'contact/edit?id=' . $contact_array['contact']->getId() ) ?></div>
        <div><?php echo $contact_array['contact']->getPhone() ?></div>
      </div>
      <ul>
        <?php foreach ( $contact_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?></li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( $web_contact ): ?>
  <h2>Web contact form registration</h2>

  <ul>
  <?php foreach ( $web_contact as $organization_array ): ?>
    <li>
      <div>
        <div><?php echo link_to( $organization_array['organization']->getName(), 'contact/edit?id=' . $organization_array['organization']->getId() ) ?></div>
        <div><?php echo $organization_array['organization']->getIpRegUri() ?></div>
      </div>
      <ul>
        <?php foreach ( $organization_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?></li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( $web_admin ): ?>
  <h2>Web admin form</h2>
  <?php foreach ( $web_admin as $organization ): ?>

  <?php endforeach; ?>
<?php endif; ?>


