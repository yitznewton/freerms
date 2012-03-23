<?php if ($statistics): ?>

<aside class="filters">
  <form method="get">
    <ul>
      <li>
        <span class="label">Start:</span>
        <?php echo $startFilter->render('dates[from]') ?>
      </li>
      <li>
        <span class="label">End:</span>
        <?php echo $endFilter->render('dates[to]') ?>
      </li>
    </ul>
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

