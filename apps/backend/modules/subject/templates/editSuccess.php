<?php use_helper('I18N', 'Date') ?>
<?php include_partial('subject/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edit Subject', array(), 'messages') ?></h1>

  <span class="metadata" id="delete-url-mask"
    title="<?php echo url_for('@database_remove_subject?subject_id='.$subject->getId().'&database_id=%') ?>"></span>

  <?php include_partial('subject/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('subject/form_header', array('subject' => $subject, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('subject/form', array('subject' => $subject, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('subject/form_footer', array('subject' => $subject, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
