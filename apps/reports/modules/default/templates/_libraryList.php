<ul>
  <?php foreach ($libraries as $library): ?>
  <li>
    <?php echo $library->getName() ?>:
    <?php echo link_to('Databases',
      '@database_by_library?filter=' . $library->getId()) ?>
    |
    <?php echo link_to('URLs',
      '@url_by_library?filter=' . $library->getId()) ?>
  </li>
  <?php endforeach; ?>
</ul>

