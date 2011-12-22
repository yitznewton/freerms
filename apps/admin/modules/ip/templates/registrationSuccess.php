<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li><?php echo link_to('IP Ranges', 'ip/index') ?> ></li>
  <li>Registration</li>
</ul>

<?php if ( $ip_reg_events ): ?>
<h2>Summary</h2>
<ul>
  <?php foreach ( $ip_reg_events as $ip_reg_event ): ?>
  <li><?php echo $ip_reg_event ?> (__REMOVE__)</li>
  <?php endforeach; ?>
</ul>
<?php else: ?>
<p>There are no unprocessed IP registration events.</p>
<?php endif; ?>

<?php if ( isset( $organizations['email'] ) ): ?>
  <h3>Email registration</h3>

  <ul>
  <?php foreach ( $organizations['email'] as $org_array ): ?>
    <li>
      <div>
        <div><?php echo link_to( $org_array['organization']->getName(), 'organization/edit?id=' . $org_array['organization']->getId() ) ?></div>
        <div><?php echo link_to( $org_array['contact']->getFirstName() . ' ' . $org_array['contact']->getLastName(), 'contact/edit?id=' . $org_array['contact']->getId() ) ?></div>
        <div><?php echo mail_to( $org_array['contact']->getFirstContactEmail() ) ?></div>
      </div>
      <ul>
        <?php foreach ( $org_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?> (__REMOVE__)</li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( isset( $organizations['phone'] ) ): ?>
  <h3>Phone registration</h3>

  <ul>
  <?php foreach ( $organizations['phone'] as $org_array ): ?>
    <li>
      <div><?php echo link_to( $org_array['organization']->getName(), 'organization/edit?id=' . $org_array['organization']->getId() ) ?></div>
      <div>
        <?php if ( $org_array['contact'] ): ?>
        <div><?php echo link_to( $org_array['contact']->getFirstName() . ' ' . $org_array['contact']->getLastName(), 'contact/edit?id=' . $org_array['contact']->getId() ) ?></div>
        <?php endif; ?>
        <div><?php echo $org_array['contact']->getFirstContactPhone() ? $org_array['contact']->getFirstContactPhone() : $org_array['organization']->getPhone() ?></div>
      </div>
      <ul>
        <?php foreach ( $org_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?> (__REMOVE__)</li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( isset( $organizations['web contact form'] ) ): ?>
  <h3>Web contact form registration</h3>

  <ul>
  <?php foreach ( $organizations['web contact form'] as $org_array ): ?>
    <li>
      <div>
        <div><?php echo link_to( $org_array['organization']->getName(), 'organization/edit?id=' . $org_array['organization']->getId() ) ?></div>
        <div><?php echo link_to( $org_array['organization']->getWebAdminUri(), $org_array['organization']->getWebAdminUri(), array( 'absolute' => true ) ) ?></div>
      </div>
      <ul>
        <?php foreach ( $org_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?> (__REMOVE__)</li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( isset( $organizations['web admin'] ) ): ?>
  <h3>Web admin form</h3>

  <ul>
  <?php foreach ( $organizations['web admin'] as $organization_array ): ?>
    <li>
      <div>
        <div><?php echo link_to( $organization_array['organization']->getName(), 'organization/edit?id=' . $organization_array['organization']->getId() ) ?></div>
        <div><?php echo link_to( $organization_array['organization']->getWebAdminUri(), $organization_array['organization']->getWebAdminUri() ) ?></div>
        <?php if ( $organization_array['organization']->getWebAdminUsername() ): ?>
          <div>Username: <?php echo $organization_array['organization']->getWebAdminUsername() ?></div>
        <?php endif; ?>
        <?php if ( $organization_array['organization']->getWebAdminPassword() ): ?>
          <div>Password: <?php echo $organization_array['organization']->getWebAdminPassword() ?></div>
        <?php endif; ?>
      </div>
      <ul>
        <?php foreach ( $organization_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?> (__REMOVE__)</li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ( isset( $organizations['other'] ) ): ?>
  <h3>Other</h3>

  <ul>
  <?php foreach ( $organizations['other'] as $organization_array ): ?>
    <li>
      <div>
        <div><?php echo link_to( $organization_array['organization']->getName(), 'organization/edit?id=' . $organization_array['organization']->getId() ) ?></div>
        <?php if ( $organization_array['organization']->getWebAdminUri() ): ?>
          <div><?php echo link_to( $organization_array['organization']->getWebAdminUri(), $organization_array['organization']->getWebAdminUri() ) ?></div>
        <?php endif; ?>
        <?php if ( $organization_array['organization']->getWebAdminUsername() ): ?>
          <div>Username: <?php echo $organization_array['organization']->getWebAdminUsername() ?></div>
        <?php endif; ?>
        <?php if ( $organization_array['organization']->getWebAdminPassword() ): ?>
          <div>Password: <?php echo $organization_array['organization']->getWebAdminPassword() ?></div>
        <?php endif; ?>
      </div>
      <ul>
        <?php foreach ( $organization_array['ip_reg_events'] as $ip_reg_event ): ?>
        <li><?php echo $ip_reg_event ?> (__REMOVE__)</li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>