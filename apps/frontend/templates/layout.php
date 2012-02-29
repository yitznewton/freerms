<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <!--[if lt IE 9]
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <?php if ($sf_user->isAuthenticated()): ?>
    <div class="logout-link">
      <?php echo link_to('Logout', '@sf_guard_signout') ?>
    </div>
    <?php endif; ?>

    <?php echo $sf_content ?>
  </body>
</html>
