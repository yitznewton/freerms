<?php if ($statistics): ?>

<aside class="filters">
  <form method="get">
    <ul>
      <li>
        <?php echo $filter['timestamp']->render() ?>
      </li>
      <li>
        <label for="database_usage_filters_library_id">Library</label>
        <?php echo $filter['library_id']->render() ?>
      </li>
      <li>
        <label for="database_usage_filters_is_onsite">Onsite?</label>
        <?php echo $filter['is_onsite']->render() ?>
      </li>
      <li>
        <label for="database_usage_filters_is_mobile">Mobile?</label>
        <?php echo $filter['is_mobile']->render() ?>
      </li>
    </ul>
    <?php echo $filter->renderHiddenFields(false) ?>
    <input type="submit" value="Refresh" />
  </form>
</aside>

<table>
  <thead>
    <tr>
      <th />
      <?php foreach ($reportMonths as $month): ?>
        <th><?php echo $month ?></th>
      <?php endforeach; ?>
      <th>Total</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($statistics as $libraryCode => $libraryMonths): ?>
    <tr>
      <th><?php echo $libraryCode ?></th>
      <?php foreach ($reportMonths as $month): ?>
        <td><?php echo isset($libraryMonths[$month]) ? $libraryMonths[$month] : '0' ?></td>
      <?php endforeach; ?>
      <td><?php echo array_sum($libraryMonths) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php else: ?>
  <p>No data.</p>
<?php endif; ?>
