<?php use_helper('Backend') ?>

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
    <header>
      <?php echo link_to(
        image_tag('freerms.png', array('alt' => 'FreERMS logo')),
        '@homepage') ?>

      <?php if ($sf_user->isAuthenticated()): ?>
        <div class="logout">Logout</div>
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
          <?php echo backend_menu_item($sf_params, 'Users', '@sf_guard_user', 'sfGuardUser') ?>
          <?php echo backend_menu_item($sf_params, 'Groups', '@sf_guard_group', 'sfGuardGroup') ?>
          <div class="clear"></div>
        </ul>
      </nav>
    </header>
    
    <?php echo $sf_content ?>
  </body>
</html>

