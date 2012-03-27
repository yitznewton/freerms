<tr id="library-<?php echo $id ?>">
  <th><?php echo $code ?></th>
  <?php foreach ($reportMonths as $month): ?>
    <td><?php echo isset($columns[$month]) ? $columns[$month] : '0' ?></td>
  <?php endforeach; ?>
  <th class="total"><?php echo array_sum($columns) ?></th>
</tr>

