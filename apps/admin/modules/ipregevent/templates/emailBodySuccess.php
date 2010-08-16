Dear <?php echo $contact->getFirstName() ?>,
<?php if ( $organization->getAccountNumber() ): ?>
Touro College Libraries, account <?php echo $organization->getAccountNumber() ?>
<?php endif; ?>

We have recently updated our IP addresses, as follows. Please update our account.

<?php foreach ( $ip_reg_events as $ip_reg_event ): ?>
<?php echo $ip_reg_event ?>

<?php endforeach; ?>

Thank you,

--
Liping Ren
liping.ren@touro.edu
