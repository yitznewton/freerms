<tr id="library-<?php echo str_replace('.', '-', $id) ?>">
  <th><?php echo link_to($label, str_replace('%', $id, $tableLinkRoute)) ?></th>
  <?php foreach ($reportMonths as $month): ?>
    <td><?php echo isset($columns[$month]) ? $columns[$month] : '0' ?></td>
  <?php endforeach; ?>
  <th class="total"><?php echo array_sum($columns) ?></th>
</tr>

