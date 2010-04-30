<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("#tab-container > ul").tabs();
    jQuery("#e_resource_db_subject_assoc_clear").show();
  });

  tab_names = new Array();
  tab_names[0] = 'general';
  tab_names[1] = 'access';
  tab_names[2] = 'libraries';
  tab_names[3] = 'admin';

  function set_tab_state() {
    active_tab = jQuery('#tab-container > ul').data('selected.tabs');
    document.getElementById('tab-state').value = tab_names[active_tab];
  }
</script>

<form action="<?php echo url_for('database/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> onsubmit="set_tab_state();">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="PUT" />
<?php endif; ?>
  <div>
    <?php echo $form->renderHiddenFields() ?>
    <input type="submit" value="Save" />
    <?php if (!$form->getObject()->isNew()): ?>
    <?php echo link_to('Delete', 'database/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
    <?php endif; ?>
  </div>

  <div id="tab-container">
    <ul>
      <li class="ui-tabs-nav-item"><a href="#general"><span>General</span></a></li>
      <li class="ui-tabs-nav-item"><a href="#access"><span>Access</span></a></li>
      <li class="ui-tabs-nav-item"><a href="#admin"><span>Admin</span></a></li>
      <li class="ui-tabs-nav-item"><a href="#libraries"><span>Libraries</span></a></li>
    </ul>

    <div id="general">
      <table>
        <tbody>
          <fieldset id="database-hot-fields">
            <?php echo $form->renderGlobalErrors() ?>
            <?php echo $form['product_unavailable']->renderRow() ?>
            <?php echo $form['suppression']->renderRow() ?>
            <?php echo $form['public_note']->renderRow() ?>
          </fieldset>
          <?php echo $form['title']->renderRow() ?>
          <?php echo $form['alt_title']->renderRow() ?>
          <?php echo $form['alt_id']->renderRow() ?>
          <?php echo $form['Acquisition']['vendor_org_id']->renderRow() ?>
          <?php echo $form['e_resource_db_subject_assoc_list']->renderRow() ?>
          <div id="e_resource_db_subject_assoc_clear" class="form-row" style="display: none;">
            <label>&nbsp;</label>
            <input type="button" value="Clear Subjects"
            onclick="clearAll(jQuery('#e_resource_e_resource_db_subject_assoc_list'))">
          </div>
          <?php echo $form['subscription_number']->renderRow() ?>
          <?php echo $form['language']->renderRow() ?>
          <?php echo $form['description']->renderRow() ?>
        </tbody>
      </table>
    </div>

    <div id="access">
      <?php echo $form['AccessInfo']->renderError() ?>
      <?php echo $form['AccessInfo'] ?>
    </div>

    <div id="admin">
      <?php echo $form['AdminInfo']->renderError() ?>
      <?php echo $form['AdminInfo'] ?>
    </div>

    <div id="libraries">
      <?php echo $form['Acquisition']->renderError() ?>
      <?php echo $form['Acquisition']['acq_lib_assoc_list']->renderRow() ?>
    </div>

  </div>

  <input type="hidden" id="tab-state" name="tab-state" value="general" />

</form>
