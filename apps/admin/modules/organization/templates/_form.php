<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<script type="text/javascript">
</script>  

<form id="organization-form" action="<?php echo url_for('organization/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> onsubmit="set_tab_state();">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="PUT" />
<?php endif; ?>
  <div>
    <?php echo $form->renderHiddenFields() ?>
    <input type="submit" value="Save" />
    <?php if (!$form->getObject()->isNew()): ?>
    <?php endif; ?>
  </div>    
  
  <div id="tab-container">
    <ul>
      <li class="ui-tabs-nav-item"><a href="#general"><span>General</span></a></li>    
      <li class="ui-tabs-nav-item"><a href="#database-vendor"><span>Databases as vendor</span></a></li>
    </ul>
         
    <div id="general">
      <table>  
        <tbody>
          <?php //echo $form->render() ?>
          <?php echo $form['name']->renderRow() ?>
          <?php echo $form['alt_name']->renderRow() ?>
          <?php echo $form['account_number']->renderRow() ?>
          <?php echo $form['address']->renderRow() ?>
          <?php echo $form['phone']->renderRow() ?>
          <?php echo $form['fax']->renderRow() ?>
          <?php echo $form['notice_address_licensor']->renderRow() ?>
          <?php echo $form['ip_reg_method_id']->renderRow() ?>
          <?php echo $form['ip_reg_force_manual']->renderRow() ?>
        <fieldset class="organization-ip-notification" id="organization-ip-notification-web">
          <?php echo $form['ip_reg_uri']->renderRow() ?>
          <?php echo $form['ip_reg_username']->renderRow() ?>
          <?php echo $form['ip_reg_password']->renderRow() ?>
        </fieldset>
        <fieldset class="organization-ip-notification" id="organization-ip-notification-contact">
          <?php echo $form['ip_reg_contact_id']->renderRow() ?>
        </fieldset>
          <?php echo $form['note']->renderRow() ?>
        </tbody>
      </table>
    </div>   
    
    <div id="database-vendor">
      <?php if ($eresources_vendor): ?>
      <?php echo "<ul class=\"database-list\">\n" ?>
        <?php foreach ($eresources_vendor as $eresource): ?>
          <li><?php echo link_to($eresource->getTitle(), 'database/edit?id='. $eresource->getId()) ?></li>
        <?php endforeach; ?>
      <?php echo "</ul>\n" ?>
      <?php endif; ?>
    </div>
  </div>
  
  <input type="hidden" id="tab-state" name="tab-state" value="general" />
  
</form>
