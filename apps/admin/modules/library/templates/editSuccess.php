<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li><?php echo link_to('Libraries', 'library/index') ?> ></li>
  <li>Edit</li>
</ul>

<?php include_partial('form', array(
  'form' => $form,
  'eresources' => $eresources,
  'ips' => $ips,
  )) ?>
