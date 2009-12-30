<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('subject/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <input type="submit" value="Save" />
          
          <?php if (!$form->getObject()->isNew()): ?>
          <?php echo link_to('Delete', 'subject/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Deleting will permanently remove this subject tag from all databases.  Are you sure?')) ?>
          <?php endif; ?>          
       </td>
     </tr>
    </tfoot>
      <tbody>
        <?php echo $form->renderGlobalErrors() ?>
     
        <?php echo $form['label']->renderRow() ?>        
        <?php echo $form['slug']->renderRow() ?>        
      </tbody>
  </table>
</form>
