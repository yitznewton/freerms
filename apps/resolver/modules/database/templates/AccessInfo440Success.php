<form method="POST"
action="http://uptodateonline.com/online/portalLogin.do"
name="uptodate">
<input type="hidden" value="<?php echo $utd_codes['portal'] ?>" name="portal">
<input type="hidden" value="<?php echo $utd_codes['key'] ?>" name="key">
<input type="submit" value="UpToDate">
</form>

<script type="text/javascript">
  document.uptodate.submit();
</script>
