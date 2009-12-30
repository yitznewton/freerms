<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li>IP Ranges</li>
</ul>

<table class="index-table">
  <thead class="ui-helper-reset ui-widget-header ui-corner-all">
    <tr>
      <th><?php echo link_to('Starting IP', 'ip/index?sort=start-ip') ?></th>
      <th>Ending IP</th>
      <th>Note</th>
      <th>Active</th>
      <th><?php echo link_to('Proxy', 'ip/index?sort=proxy') ?></th>
      <th><?php echo link_to('Library', 'ip/index?sort=library') ?></th>
    </tr>
  </thead>
  <tbody class="ui-helper-reset ui-widget-content ui-corner-all">
    <?php foreach ($ip_range_list as $ip_range): ?>
    <tr>
      <td><?php echo link_to($ip_range->getStartIp(), 'ip/edit?id='.$ip_range->getId()) ?></td>
      <?php if ($ip_range->getEndIp()): ?>
      <td><?php echo link_to($ip_range->getEndIp(), 'ip/edit?id='.$ip_range->getId()) ?></td>
      <?php else: ?>
      <td />
      <?php endif; ?>
      <td><?php echo $ip_range->getNote() ?></td>
      <td><?php echo $ip_range->getActiveIndicator() ? 'y' : '' ?></td>
      <td><?php echo $ip_range->getProxyIndicator() ? 'y' : '' ?></td>
      <td>
      <?php echo link_to(
        $ip_range->getLibrary()->getName(),
        'library/edit?id='.$ip_range->getLibrary()->getId()
      ) ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('ip/new') ?>">New</a>
