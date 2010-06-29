<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript">
var emails = <?php echo ($form['emails']->count()) ?>;

function getEmail(num) {
  var r = $.ajax({
    type: 'GET',
    url: '<?php echo url_for('contact/addEmailForm')?>'+'<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
    async: false
  }).responseText;
  return r;
}

function add_email(){
  $("#email-container").append(getEmail(emails));
    emails = emails + 1;
  return false;
} 
</script>

<form action="<?php echo url_for('contact/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table id="test" border="0" cellpadding="0" cellspacing="0">
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

          <?php if (!$form->getObject()->isNew()): ?>
            <a href="#" class="input-link" onclick="return add_email();">Add new</a>
          <?php endif; ?>
        </td>
      </tr>           

<!--
      <tr class="form-row">
        <td>
          <?php //echo $form['phones'] -> renderLabel() ?>
        </td>
        <td>
          <?php //foreach ($form['phones'] as $phone): ?>
          <?php //echo $phone->renderError() ?>
          <?php //echo $phone->render() ?>
          <?php //endforeach; ?>
        </td>
      </tr>
!-->
    </tbody>
  </table>
</form>
