<h2>Welcome! Please log in to administer FreERMS:</h2>

<form method="POST" action="<?php echo url_for( 'user/login' ) ?>">

<?php echo $form->render() ?>

<input type="submit" />

</form>
