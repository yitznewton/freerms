<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li>Contacts</li>
</ul>

<table class="index-table">
  <thead class="ui-helper-reset ui-widget-header ui-corner-all">
    <tr>      
      <th>Name</th>
    </tr>
  </thead>
  <tbody class="ui-helper-reset ui-widget-content ui-corner-all">
    <?php foreach ($Contacts as $Contact): ?>
    <tr>
      <td><a href="<?php echo url_for('contact/edit?id='.$Contact->getId()) ?>"><?php echo $Contact ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('contact/new') ?>">New</a>
