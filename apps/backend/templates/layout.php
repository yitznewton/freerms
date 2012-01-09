<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <nav>
      <ul>
        <li><?php echo link_to('Databases', '@database') ?></li>
        <li><?php echo link_to('Subjects', '@subject') ?></li>
        <li><?php echo link_to('Libraries', '@library') ?></li>
        <li><?php echo link_to('IP Ranges', '@ip_range') ?></li>
      </ul>
    </nav>
    
    <?php echo $sf_content ?>
  </body>
</html>
