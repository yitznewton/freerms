<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li><?php echo link_to('Contacts', 'contact/index') ?> ></li>
  <li>New</li>
</ul>

<?php include_partial('form', array('form' => $form)) ?>
