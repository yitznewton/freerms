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
          <li class="<?php echo $sf_params->get('module') == 'database'
            && $sf_params->get('action') != 'homepageFeatured' ? 'ui-state-active' : 'ui-state-default' ?>">
            <?php if ($sf_params->get('module') == 'database'
              && $sf_params->get('action') == 'index'): ?>
              Databases
            <?php else: ?>
              <?php echo link_to('Databases', '@database') ?>
            <?php endif; ?>
          </li>
          <li class="<?php echo $sf_params->get('module') == 'subject' ? 'ui-state-active' : 'ui-state-default' ?>">
            <?php if ($sf_params->get('module') == 'subject'
              && $sf_params->get('action') == 'index'): ?>
              Subjects
            <?php else: ?>
              <?php echo link_to('Subjects', '@subject') ?>
            <?php endif; ?>
          </li>
          <li class="<?php echo $sf_params->get('module') == 'library' ? 'ui-state-active' : 'ui-state-default' ?>">
            <?php if ($sf_params->get('module') == 'library'
              && $sf_params->get('action') == 'index'): ?>
              Libraries
            <?php else: ?>
              <?php echo link_to('Libraries', '@library') ?>
            <?php endif; ?>
          </li>
          <li class="<?php echo $sf_params->get('module') == 'ip_range' ? 'ui-state-active' : 'ui-state-default' ?>">
            <?php if ($sf_params->get('module') == 'ip_range'
              && $sf_params->get('action') == 'index'): ?>
              IP Ranges
            <?php else: ?>
              <?php echo link_to('IP Ranges', '@ip_range') ?>
            <?php endif; ?>
          </li>
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

