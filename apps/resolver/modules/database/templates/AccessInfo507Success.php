<form method="POST"
action="http://smallbusinessschool.org/page160.html"
name="theform">
<input type="hidden" value="<?php echo $credentials['user'] ?>" name="login">
<input type="hidden" value="<?php echo $credentials['pass'] ?>" name="password">
<input type="hidden" value="LOGON" name="action">
<input type="submit" value="Small Business School">
</form>

<script type="text/javascript">
  document.theform.submit();
</script>
