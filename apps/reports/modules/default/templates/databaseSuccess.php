<?php if ($statistics): ?>

<aside class="filters">
  <form method="get">
    <ul>
      <li id="filter-timestamp">
        <?php echo $filter['timestamp']->render() ?>
      </li>
      <li id="filter-is-onsite">
        <label for="database_usage_filters_is_onsite">Onsite?</label>
        <?php echo $filter['is_onsite']->render() ?>
      </li>
      <li id="filter-is-mobile">
        <label for="database_usage_filters_is_mobile">Mobile?</label>
        <?php echo $filter['is_mobile']->render() ?>
      </li>
      <li id="filter-library">
        <label for="database_usage_filters_library_id">Library</label>
        <?php echo $filter['library_id']->render() ?>
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
  <?php foreach ($statistics as $id => $data): ?>
    <?php include_partial('libraryRow', array('id' => $id,
      'code' => $data['code'], 'columns' => $data['months'],
      'reportMonths' => $reportMonths)) ?>
  <?php endforeach; ?>
  </tbody>
</table>

<?php else: ?>
  <p>No data.</p>
<?php endif; ?>

