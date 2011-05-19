<h2>Welcome! Please log in to access electronic resources:</h2>

<?php
if ($errors) {
  echo "<ul id=\"errors\">\n";
  
  foreach ($errors as $e) {
    echo "<li>$e</li>\n";
  }
  
  echo "</ul>\n";
}
?>  

<form id="login-form" method="post">
  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo $username ?>" tabindex="1" />
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" name="password" tabindex="2"  />
  </div>
  <div>  
    <input type="submit" value="Submit" tabindex="3"  />
  </div>
</form>