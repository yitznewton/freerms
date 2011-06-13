<h2>Welcome! Please sign in to access electronic resources:</h2>

<form class="form-signin" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table>
    <?php echo $form ?>
  </table>

  <input type="submit" value="sign in" />
</form>

<p><?php echo link_to('Register here', 'https://accounts.tourolib.org/register') ?>.</p>
<p><?php echo link_to('Forgot your username or password?', 'https://accounts.tourolib.org/resetPassword') ?></p>
