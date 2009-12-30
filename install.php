<?php

echo <<<EOF

================================================
Congratulations on installing/upgrading FreERMS!
================================================


EOF;

// check dependencies

echo "Checking dependencies...\n";

$deps = array(
  'PDO',
  'pdo_mysql',
);

$missing = '';
foreach ($deps as $d) {
  if (!extension_loaded($d)) {
    $missing .= "$d, ";
  }
}

if ($missing) {
  $error  = "The following PHP dependencies are missing:\n";
  $error .= substr($missing,0,-2)."\n\n";
  $error .= "INSTALLATION FAILED.\n\n";

  exit($error);
}
else {
  echo "Done.\n\n";
}

// copy sample files

echo "Creating local copies of sample files...\n\n";

$dir = dirname(__FILE__);

if (strtoupper(substr(PHP_OS,0,3)) == 'WIN') {
  exec("dir /s /b \"$dir\\*.sample\"", $samples);
}
else {
  exec("find $dir -name *sample -print", $samples);
}

$diffs = array();

foreach ($samples as $s) {
  $nicename = substr($s, 1-strlen($s)+strlen($dir));
  $newname = str_replace('.sample', '', $nicename);

  if (file_exists("$dir/$newname")) {
    echo "NOT overwriting existing $newname\n";
    
    // check for local changes
    $old_file_array = file("$dir/$newname");
    $new_file_array = file($s);
    if (array_diff($old_file_array, $new_file_array)) {
      $diffs[] = "$newname";
    }
  }
  else {
    copy($s, "$dir/$newname");
    echo "Copying $nicename\n";
  }
}

if ($diffs) {
  echo "\nIMPORTANT: the following local copies differ from the current\n";
  echo "samples; you should check for new features or settings:\n";
  
  foreach ($diffs as $d) {
    echo "$d\n";
  }
}

echo "\nINSTALLATION COMPLETE.  Documentation is at ";
echo "http://freerms.tourolib.org/\n\n";

