<?php if ($statistics): ?>

<aside class="filters">
  <form method="get">
    <ul>
      <li id="filter-timestamp">
        <?php echo $filter['timestamp']->render() ?>
      </li>
      <li id="filter-is-onsite">
        <label for="is_onsite">Onsite?</label>
        <?php echo $filter['is_onsite']->render() ?>
      </li>
      <li id="filter-is-mobile">
        <label for="is_mobile">Mobile?</label>
        <?php echo $filter['is_mobile']->render() ?>
      </li>
    </ul>
    <?php echo $filter->renderHiddenFields(false) ?>
    <input type="submit" value="Refresh" />
  </form>
</aside>

<section id="primary-graph">
  <div id="primary-graph-target"></div>
  <div id="filter-library">
    <div class="label">Library</div>
    <?php echo $filter['library_id']->render() ?>
  </div>
</section>

<section id="primary-data">
  <p>You can copy and paste data into Excel.
  <a id="monthly-toggle" href="#">Toggle monthly columns</a></p>

  <table id="primary-data-table">
    <thead>
      <tr>
        <th></th>
        <?php foreach ($reportMonths as $month): ?>
          <th><?php echo $month ?></th>
        <?php endforeach; ?>
        <th class="total">Total</th>
      </tr>
    </thead>

    <tbody>
    <?php foreach ($statistics as $id => $data): ?>
      <?php include_partial('libraryRow', array('id' => $id,
        'code' => $data['code'], 'columns' => $data['months'],
        'reportMonths' => $reportMonths)) ?>
    <?php endforeach; ?>
    </tbody>

    <tfoot>
      <tr class="totals">
        <th>Total</th>
        <?php foreach ($reportMonths as $month): ?>
          <td>
            <?php echo array_sum(array_map(function($library) use ($month) {
              return isset($library['months'][$month]) ? $library['months'][$month] : 0;
            }, $statistics)) ?>
          </td>
        <?php endforeach; ?>
        <th>
          <?php echo array_sum(array_map(function($library) use ($month) {
            return isset($library['months']) ? array_sum($library['months']) : 0;
          }, $statistics)) ?>
        </th>
      </tr>
    </tfoot>
  </table>
</section>

<section class="share-list">
  <dl id="onsite-share-list">
    <dt>Onsite</dt>
    <dd><?php echo round($onsiteShare['1'] / array_sum($onsiteShare) * 100, 1) ?>%</dd>
    <dt>Offsite</dt>
    <dd><?php echo round($onsiteShare['0'] / array_sum($onsiteShare) * 100, 1) ?>%</dd>
  </dl>
  <canvas id="onsite-share-canvas"></canvas>
</section>

<section class="share-list">
  <dl id="mobile-share-list">
    <dt>Mobile</dt>
    <dd><?php echo round($mobileShare['1'] / array_sum($mobileShare) * 100, 1) ?>%</dd>
    <dt>Non-mobile</dt>
    <dd><?php echo round($mobileShare['0'] / array_sum($mobileShare) * 100, 1) ?>%</dd>
  </dl>
  <canvas id="mobile-share-canvas"></canvas>
</section>

<?php else: ?>
  <p>No data.</p>
<?php endif; ?>

