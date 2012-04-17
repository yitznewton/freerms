<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>

    <?php if (has_slot('title')): ?>
    <title><?php include_slot('title') ?> | FreERMS Reports</title>
    <?php else: ?>
    <title>FreERMS Reports</title>
    <?php endif; ?>

    <link rel="shortcut icon" href="/favicon.ico" />
    <!--[if IE]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <header>
      <?php echo link_to(
        image_tag('freerms.png', array('alt' => 'FreERMS logo')),
        '@homepage') ?>

      <nav class="links">
        <ul>
          <li><a href="<?php echo strtr( url_for('@homepage'), array(
            'reports.php/' => 'backend.php',
            'reports_dev.php/' => 'backend_dev.php/'
          )) ?>">Backend Home</a></li>
          <li><?php echo link_to('Reports Home', '@homepage') ?></li>
          <li><a href="<?php echo strtr( url_for('@homepage'), array(
            'reports.php/' => '',
            'reports_dev.php/' => 'frontend_dev.php/'
          )) ?>">Frontend Home</a></li>
        </ul>
      </nav>

      <?php if ($sf_user->isAuthenticated()): ?>
      <div class="logout-link">
        <?php echo link_to('Logout', '@sf_guard_signout') ?>
      </div>
      <?php endif; ?>
    </header>
    
    <?php echo $sf_content ?>
  </body>
</html>

