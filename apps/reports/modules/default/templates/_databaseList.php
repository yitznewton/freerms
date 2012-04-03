<ul>
  <?php foreach ($databases as $database): ?>
  <li>
    <?php echo link_to($database->getTitle(),
      '@database_by_database?filter=' . $database->getId()) ?>
  </li>
  <?php endforeach; ?>
</ul>

