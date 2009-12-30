<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li><?php echo link_to('Databases', 'database/index') ?> ></li>
  <li>Edit <?php echo $form->getObject()->getTitle() ?></li>
</ul>

<div id="user-url">
  User URL:
  <a href="<?php echo $form->getObject()->getUserURL() ?>">
    <?php echo $form->getObject()->getUserURL() ?>
  </a>
</div>

<?php include_partial('form', array('form' => $form)) ?>
