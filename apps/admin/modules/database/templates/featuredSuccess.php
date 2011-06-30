<ul id="breadcrumbs">
  <li><?php echo link_to('Home', '@homepage') ?> ></li>
  <li>Edit featured databases</li>
</ul>

<p>The current page is for homepage featured databases. To add a database
  to the list, use the database's edit page. For featured databases
  by subject, use
<?php echo link_to('the subjects page', 'subject/index') ?>.</p>

<div id="admin-featured-databases">
  <form id="admin-form-featured" method="POST">
    <?php echo $form ?>
    <input type="submit" value="Submit" />
  </form>
</div>
