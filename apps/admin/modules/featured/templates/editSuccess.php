<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li>Edit featured databases</li>
</ul>

<p>The current page is for homepage featured databases. For featured databases
by subject, use
<?php echo link_to('the subjects page', 'subject/index') ?>.</p>

<?php include_partial('form', array('form' => $form)) ?>
