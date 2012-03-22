<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
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
            'reporting.php/' => 'backend.php',
            'reporting_dev.php/' => 'backend_dev.php/'
          )) ?>">Backend Home</a></li>
          <li><a href="<?php echo strtr( url_for('@homepage'), array(
            'reporting.php/' => '',
            'reporting_dev.php/' => 'frontend_dev.php/'
          )) ?>">Frontend Home</a></li>
          <li><?php echo link_to('Reporting Home', '@homepage') ?></li>
        </ul>
      </nav>

      <?php if ($sf_user->isAuthenticated()): ?>
      <div class="logout-link">
        <?php echo link_to('Logout', '@sf_guard_signout') ?>
      </div>
      <?php endif; ?>

      <nav class="ui-widget-header">
        <ul>
          <?php echo backend_menu_item($sf_params, 'Databases', '@database', 'database', 'homepageFeatured') ?>
          <?php echo backend_menu_item($sf_params, 'Subjects', '@subject', 'subject') ?>
          <?php echo backend_menu_item($sf_params, 'Libraries', '@library', 'library') ?>
          <?php echo backend_menu_item($sf_params, 'IP Ranges', '@ip_range', 'ip_range') ?>
          <?php if ($sf_params->get('module') == 'database' && $sf_params->get('action') == 'homepageFeatured'): ?>
            <li class="ui-state-active">Featured Databases</li>
          <?php else: ?>
            <li class="ui-state-default"><?php echo link_to('Featured Databases', '@database_homepage_featured') ?></li>
          <?php endif; ?>
          <div class="clear"></div>
        </ul>
      </nav>
    </header>
    
    <?php echo $sf_content ?>
  </body>
</html>

