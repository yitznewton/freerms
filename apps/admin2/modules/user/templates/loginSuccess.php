<h2>Welcome! Please log in to administer FreERMS:</h2>

<form action="<?php echo url_for(user/login) ?>" method="post">
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>

      <?php echo $form['username']->renderRow() ?>
      <?php echo $form['password']->renderRow() ?>
    </tbody>
  </table>

  <input type="submit" value="Submit"  />

</form>