<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form id="admin-form-database" action="<?php echo url_for('database/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="PUT" />
<?php endif; ?>
  <div>
    <?php echo $form['id'] ?>
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
      <li class="ui-tabs-nav-item"><a href="#subjects"><span>Subjects</span></a></li>
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
          <?php echo $form['subscription_number']->renderRow() ?>
          <?php echo $form['language']->renderRow() ?>
          <?php echo $form['description']->renderRow() ?>
        </tbody>
      </table>
    </div>

    <div id="access">
      <?php echo $form['AccessInfo'] ?>
    </div>

    <div id="admin">
      <?php echo $form['AdminInfo'] ?>
    </div>

    <div id="libraries">
      <?php echo $form['Acquisition']->renderError() ?>
      <?php echo $form['Acquisition']['acq_lib_assoc_list']->renderRow() ?>
    </div>

    <div id="subjects">
      <?php echo $form['e_resource_db_subject_assoc_list'] ?>
    </div>

  </div>
</form>
