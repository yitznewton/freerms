<h2>By database</h2>
<?php include_partial('databaseList', array('databases' => $databases)) ?>

<h2>By library</h2>
<?php include_partial('libraryList', array('libraries' => $libraries)) ?>

<h2>By URL (for direct URLs)</h2>
<?php include_partial('hostList', array('hosts' => $hosts)) ?>

