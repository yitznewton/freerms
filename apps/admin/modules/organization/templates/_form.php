<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("#tab-container > ul").tabs();

  });

  tab_names = new Array();
  tab_names[0] = 'general';
  tab_names[1] = 'ip-ranges';
  tab_names[2] = 'databases';
</script>

<form action="<?php echo url_for('organization/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> onsubmit="set_tab_state();" id="organization-form">
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
      <li class="ui-tabs-nav-item"><a href="#contacts"><span>Contacts</span></a></li>
      <!-- <li class="ui-tabs-nav-item"><a href="#database-negotiator"><span>Databases as negotiator</span></a></li> -->
    </ul>

    <div id="general">
      <table>
        <tbody>
          <?php echo $form->renderGlobalErrors() ?>
          <?php echo $form['name']->renderRow() ?>
          <?php echo $form['alt_name']->renderRow() ?>
          <?php echo $form['account_number']->renderRow() ?>
          <?php echo $form['address']->renderRow() ?>
          <?php echo $form['phone']->renderRow() ?>
          <?php echo $form['fax']->renderRow() ?>
          <?php echo $form['notice_address_licensor']->renderRow() ?>
          <?php echo $form['web_admin_uri']->renderRow() ?>
          <?php echo $form['web_admin_username']->renderRow() ?>
          <?php echo $form['web_admin_password']->renderRow() ?>
          <?php echo $form['ip_reg_method_id']->renderRow() ?>
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
        <?php $id = $eresource->getId() ?>
        <?php echo "<li>" ?>
        <?php echo link_to($eresource->getTitle(), 'database/edit?id='. $id) ?>
        <?php echo '</li>' ?>
        <?php endforeach; ?>
      <?php echo "</ul>\n" ?>
      <?php endif; ?>

    </div>

    <div id="contacts">
      <?php if ($contacts): ?>
      <table id="ip-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>               
          </tr>
        </thead>

        <tbody>
          <?php foreach ($contacts as $contact): ?>
          <tr>
            <td><?php echo link_to($contact, 'contact/edit?id='.$contact->getId()) ?></td>
            <td><?php echo $contact->getRole() ?></td>
            <td><a href="mailto:<?php echo $contact->getEmail() ?>">
              <?php echo $contact->getEmail() ?></a>
            </td>
            <td><?php echo link_to('delete', 'contact/delete?id='.$contact->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>

      <?php if (! $form->getObject()->isNew() ): ?>
      <div><?php echo link_to('Add', 'contact/new?organization='.$form->getObject()->getId()) ?></div>
      <?php endif; ?>       
    </div>
    
    <!--
    <div id="database-negotiator">
    </div>
    -->
  </div>

  <input type="hidden" id="tab-state" name="tab-state" value="general" />

</form>
