<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
  <div id="container">
  	<div id="header">
  	  <a href="<?php echo url_for('homepage')?>">
        <img id="logo" src="/images/freerms.png" alt="FreERMS logo" />
      </a>
      <div id="logo-localization">
        for <?php echo sfConfig::get('app_institution-name') ?>
      </div>
    </div>
    <div id="nav">
      <ul class="nav-links">

        <?php if ($this->getActionName() != 'index'
          || $this->getModuleName() != 'database'): ?>
        <li class="menu-link">
          <a href="<?php echo url_for('database/index') ?>">Databases</a>
        </li>
        <?php else: ?>
        <li class="menu-link-current">Databases</li>
        <?php endif; ?>

        <?php if ($this->getActionName() != 'index'
          || $this->getModuleName() != 'library'): ?>
        <li class="menu-link">
          <a href="<?php echo url_for('library/index') ?>">Libraries</a>
        </li>
        <?php else: ?>
        <li class="menu-link-current">Libraries</li>
        <?php endif; ?>

        <?php if ($this->getActionName() != 'index'
          || $this->getModuleName() != 'ip'): ?>
        <li class="menu-link">
          <a href="<?php echo url_for('ip/index') ?>">IP Ranges</a>
        </li>
        <?php else: ?>
        <li class="menu-link-current">IP Ranges</li>
        <?php endif; ?>

        <?php if ($this->getActionName() != 'index'
          || $this->getModuleName() != 'subject'): ?>
        <li class="menu-link">
          <a href="<?php echo url_for('subject/index') ?>">Subjects</a>
        </li>
        <?php else: ?>
        <li class="menu-link-current">Subjects</li>
        <?php endif; ?>

      </ul>

      <?php if ($sf_user->isAuthenticated()): ?>
      <ul class="nav-links">
        <li class="menu-link">
          <a href="<?php echo url_for('user/logout') ?>">Logout</a>
        </li>
      </ul>
      <?php endif; ?>

  	</div>

    <div id="content">
      <?php echo $sf_content ?>
    </div>

  </div>

  <div id="footer">
    <p>FreERMS
    is &copy; 2010 Yitzchak Schaffer.</p>
    <p>For more information, visit the project at
    <a href="http://bitbucket.org/yitznewton/freerms">
      http://bitbucket.org/yitznewton/freerms
    </a></p>
  </div>

</body>
</html>
