<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li><?php echo link_to('Organizations', 'organization/index') ?> ></li>
  <li>Edit <?php echo $form->getObject()->getName() ?></li>
</ul>

<?php include_partial('form', array(
  'form' => $form,
  'eresources_vendor' => $eresources_vendor,
  'contacts' => $contacts,
  )) ?>