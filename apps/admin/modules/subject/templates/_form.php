<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form id="admin-form-subject" action="<?php echo url_for('subject/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<div>
  <?php echo $form['id'] ?>
  <?php echo $form->renderHiddenFields() ?>
  <input type="submit" value="Save" />
  <?php if (!$form->getObject()->isNew() && !$form->getObject()->isHomeSubject()): ?>
  <?php echo link_to('Delete', 'database/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
  <?php endif; ?>
</div>

<div id="tab-container">
  <ul>
    <li class="ui-tabs-nav-item"><a href="#admin-subject-general"><span>General</span></a></li>
    <li class="ui-tabs-nav-item"><a href="#admin-subject-databases"><span>Databases</span></a></li>
  </ul>

  <div id="admin-subject-general">
    <table>
      <tbody>
        <?php echo $form->renderGlobalErrors() ?>

        <?php echo $form['label']->renderRow() ?>
        <?php echo $form['slug']->renderRow() ?>
      </tbody>
    </table>
  </div>

  <div id="admin-subject-databases">
    <p>To remove a database, click on it to edit.</p>

    <?php foreach ( $form['EResourceDbSubjectAssocs'] as $er_form ): ?>
      <?php echo $er_form ?>
    <?php endforeach; ?>
  </div>
</div>

</form>
