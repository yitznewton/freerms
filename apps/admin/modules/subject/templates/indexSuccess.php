<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li>Subjects</li>
</ul>

<table class="index-table">
  <thead class="ui-helper-reset ui-widget-header ui-corner-all">
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody class="ui-helper-reset ui-widget-content ui-corner-all">
    <?php foreach ($db_subject_list as $db_subject): ?>
    <tr>
      <td><?php echo link_to($db_subject->getLabel(), 'subject/edit?id='.$db_subject->getId()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('subject/new') ?>">New</a>
