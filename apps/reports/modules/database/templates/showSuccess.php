<?php if ($statistics): ?>

<table>
  <thead>
    <tr>
      <th />
      <?php foreach ($reportMonths as $month): ?>
        <th><?php echo $month ?></th>
      <?php endforeach; ?>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($statistics as $libraryCode => $libraryMonths): ?>
    <tr>
      <th><?php echo $libraryCode ?></th>
      <?php foreach ($reportMonths as $month): ?>
        <td><?php echo isset($libraryMonths[$month]) ? $libraryMonths[$month] : '0' ?></td>
      <?php endforeach; ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php else: ?>
  <p>No data.</p>
<?php endif; ?>

