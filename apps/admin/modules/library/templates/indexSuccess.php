<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li>Libraries</li>
</ul>

<table class="index-table">
  <thead class="ui-helper-reset ui-widget-header ui-corner-all">
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody class="ui-helper-reset ui-widget-content ui-corner-all">
    <?php foreach ($library_list as $library): ?>
    <tr>
      <td><?php echo link_to($library->getName(), 'library/edit?id='.$library->getId()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('library/new') ?>">New</a>
