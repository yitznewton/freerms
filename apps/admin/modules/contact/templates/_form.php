<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript">
  var subform_url = '<?php echo url_for('contact/addSubform') ?>';
  var object_id   = '<?php echo $form->getObject()->getId() ?>';
  var is_new      = '<?php echo $form->getObject()->isNew() ?>';
  var email_count = <?php echo ($form['ContactEmails']->count()) ?>;
  var phone_count = <?php echo ($form['ContactPhones']->count()) ?>;
</script>

<form action="<?php echo url_for('contact/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table border="0" cellpadding="0" cellspacing="0">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <input type="submit" value="Save" />

          <?php if (!$form->getObject()->isNew()): ?>
          <?php echo link_to('Delete', 'contact/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Deleting will permanently remove this subject tag from all databases.  Are you sure?')) ?>
          <?php endif; ?>
       </td>
     </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <?php echo $form['last_name']->renderRow() ?>
      <?php echo $form['first_name']->renderRow() ?>
      <?php echo $form['title']->renderRow() ?>
      <?php echo $form['role']->renderRow() ?>
      <?php echo $form['address']->renderRow() ?>
      <?php echo $form['fax']->renderRow() ?>
      <?php echo $form['note']->renderRow() ?>
      <?php echo $form['org_id']->renderRow() ?>

      <tr class="form-row">
        <td>
          <?php echo $form['ContactEmails']->renderLabel() ?>
        </td>
        <td>
          <div id="email-container">
            <?php foreach ($form['ContactEmails'] as $key => $email): ?>
            <?php echo $email->render() ?>
            <?php endforeach; ?>
          </div>         
        </td>
      </tr>
      
      <tr class="form-row">
        <td>
          <?php echo $form['ContactPhones']->renderLabel() ?>
        </td>
        <td>
          <div id="phone-container">
            <?php foreach ($form['ContactPhones'] as $phone): ?>
            <?php echo $phone->render() ?>
            <?php endforeach; ?>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</form>
