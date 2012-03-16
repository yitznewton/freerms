<?php use_helper('I18N', 'Date') ?>
<?php include_partial('library/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('', array(), 'messages') ?></h1>

  <?php include_partial('library/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('library/form_header', array('library' => $library, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('library/form', array('library' => $library, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper, 'databases' => $databases)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('library/form_footer', array('library' => $library, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
