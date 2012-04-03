<ul>
  <?php foreach ($hosts as $host): ?>
  <li>
    <?php echo link_to($host,
      '@url_by_host?filter=' . $host) ?>
  </li>
  <?php endforeach; ?>
</ul>

