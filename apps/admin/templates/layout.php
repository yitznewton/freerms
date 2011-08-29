<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body>
  <div id="container">
  	<div id="header">
  	  <a href="<?php echo url_for('homepage')?>">
        <?php echo image_tag('freerms.png', array('alt'=>'FreERMS logo', 'id' => 'logo')) ?>
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
          || $this->getModuleName() != 'organization'): ?>
        <li class="menu-link">
          <a href="<?php echo url_for('organization/index') ?>">Vendors</a>
        </li>
        <?php else: ?>
        <li class="menu-link-current">Vendors</li>
        <?php endif; ?>

        <?php if ($this->getActionName() != 'index'
          || $this->getModuleName() != 'subject'): ?>
        <li class="menu-link">
          <a href="<?php echo url_for('subject/index') ?>">Subjects</a>
        </li>  
        <?php else: ?>
        <li class="menu-link-current">Subjects</li>  
        <?php endif; ?>

        <?php if ($this->getActionName() != 'edit'
          || $this->getModuleName() != 'featured'): ?>
        <li class="menu-link">
          <a href="<?php echo url_for('@database_featured') ?>">Featured databases</a>
        </li>  
        <?php else: ?>
        <li class="menu-link-current">Featured databases</li>  
        <?php endif; ?>

      </ul> 
      
      <?php if ($sf_user->isAuthenticated()): ?>
      <ul class="nav-links">	  
        <li class="menu-link">
          <a href="<?php echo url_for('sfGuardAuth/signout') ?>">Logout</a>
        </li>  
      </ul> 
      <?php endif; ?>
      
  	</div>		
  	
    <div id="content">		  
      <?php // include_component( 'ip', 'unregistered' ) ?>
      <?php echo $sf_content ?>
    </div>
    
  </div>

  <div id="footer">
    <p>FreERMS
    is &copy; 2011 yitznewton.</p>
    <p>For more information, visit the project at
    <a href="https://github.com/yitznewton/freerms">
      https://github.com/yitznewton/freerms
    </a></p>
  </div>

</body>
</html>
