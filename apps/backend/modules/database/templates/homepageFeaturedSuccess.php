<?php use_helper('I18N', 'Date') ?>
<?php include_partial('database/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Set order of homepage Featured Databases', array(), 'messages') ?></h1>

  <?php include_partial('database/flashes') ?>

  <p class="featured-help">You can add a database by selecting it in the
  <?php echo link_to('Databases', '@database') ?> area
  and checking the "Feature on homepage" box.</p>

  <div id="sf_admin_header">
  </div>

  <div id="sf_admin_content">
    <div class="sf_admin_form" id="featured-databases">
      <form action="<?php echo url_for('@database_homepage_featured') ?>"
            method="POST">
        <?php echo $form->renderHiddenFields(false) ?>

        <?php if ($form->hasGlobalErrors()): ?>
          <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>

        <table id="featured-parent-table">
        <?php echo $form->render() ?>
        </table>

        <input type="submit" value="Save" />
      </form>
    </div>
  </div>

  <div id="sf_admin_footer">
  </div>
</div>

