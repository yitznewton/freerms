<?php if ($ip_range->getEndIp()): ?>
  <?php echo link_to($ip_range->getEndIp(), 'ip/edit?id='.$ip_range->getId()) ?>
<?php endif; ?>