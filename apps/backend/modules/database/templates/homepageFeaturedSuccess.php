<?php use_helper('I18N', 'Date') ?>
<?php include_partial('database/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Set order of homepage Featured Databases', array(), 'messages') ?></h1>

  <?php include_partial('database/flashes') ?>

  <div id="sf_admin_header">
  </div>


  <div id="sf_admin_content">
    <div class="sf_admin_form">
      <form action="<?php echo url_for('@database_homepage_featured') ?>"
            method="POST">
        <?php echo $form->renderHiddenFields(false) ?>

        <?php if ($form->hasGlobalErrors()): ?>
          <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>

        <?php echo $form->render() ?>

        <input type="submit" value="Save" />
      </form>
    </div>
  </div>

  <div id="sf_admin_footer">
  </div>
</div>

