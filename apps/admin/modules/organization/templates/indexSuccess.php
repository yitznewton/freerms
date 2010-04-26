<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li>Organizations</li>
</ul>

<table class="index-table">
  <thead class="ui-helper-reset ui-widget-header ui-corner-all">
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody class="ui-helper-reset ui-widget-content ui-corner-all">
    <?php foreach ($organizations as $organization): ?>
    <tr>
      <td><?php echo link_to($organization->getName(), 'organization/edit?id='.$organization->getId()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('organization/new') ?>">New</a>
