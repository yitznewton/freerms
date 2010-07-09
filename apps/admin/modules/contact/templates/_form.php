<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript">
var email_count = <?php echo ($form['emails']->count()) ?>;
var phone_count = <?php echo ($form['phones']->count()) ?>;

function getSubform(type, index) {
  return $.ajax({
    type: 'GET',
    url: '<?php echo url_for('contact/addSubform') ?>?type=' + type + '<?php echo ($form->getObject()->isNew()?'':'&id='.$form->getObject()->getId()).'&index='?>' + index,
    async: false
  }).responseText;
}

function addEmail(){
  $("#email-container").append(getSubform('Email', email_count));
  email_count++;

  return false;
}

function addPhone(){
  $("#phone-container").append(getSubform('Phone', phone_count));
  phone_count++;

  return false;
}
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
      <?php echo $form['last_name'] -> renderRow() ?>
      <?php echo $form['first_name'] -> renderRow() ?>
      <?php echo $form['title'] -> renderRow() ?>
      <?php echo $form['role'] -> renderRow() ?>
      <?php echo $form['address'] -> renderRow() ?>
      <?php echo $form['fax'] -> renderRow() ?>
      <?php echo $form['note'] -> renderRow() ?>
      <?php echo $form['org_id'] -> renderRow() ?>

      <tr class="form-row">
        <td>
          <?php echo $form['emails'] -> renderLabel() ?>          
        </td>
        <td>
          <div id="email-container">
            <?php foreach ($form['emails'] as $key => $email): ?>
            <?php echo $email->render() ?>
            <?php endforeach; ?>
          </div>         
        </td>
      </tr>
      
      <tr class="form-row">
        <td>
          <?php echo $form['phones'] -> renderLabel() ?>
        </td>
        <td>
          <div id="phone-container">
            <?php foreach ($form['phones'] as $phone): ?>
            <?php echo $phone->render() ?>
            <?php endforeach; ?>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</form>
