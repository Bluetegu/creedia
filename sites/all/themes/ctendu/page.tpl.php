<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" lang="<?php print $language; ?>" xml:lang="<?php print $language; ?>">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php print $head_title; ?></title>
    <?php print $head; ?>
    <?php print $styles; ?>
    <!--
      Using conditional comments to load some CSS files with specific styles and CSS hacks for IE.
      There are some non-standard hacks that relate to all IE versions and some
      That are needed only for IE6 (or lower if your theme supports it),
      so I added two different files - one for all IE versions and one for IE6 and below.
      Hopefully, IE8 and above won't need any of this mess.
      For more information: http://msdn.microsoft.com/en-us/library/ms537512.aspx
    -->
    <!--[if IE]>
      <link rel="stylesheet" href="/<?php print path_to_theme() ?>/ie.css" type="text/css" media="screen" charset="utf-8" />
      <?php if (module_invoke('i18n', 'language_rtl')) :?>
        <link rel="stylesheet" href="/<?php print path_to_theme() ?>/ie-rtl.css" type="text/css" media="screen" charset="utf-8" />
      <?php endif ?>
    <![endif]-->
	
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/<?php print path_to_theme() ?>/ie6.css" type="text/css" media="screen" charset="utf-8" />
      <?php if (module_invoke('i18n', 'language_rtl')) :?>
        <link rel="stylesheet" href="/<?php print path_to_theme() ?>/ie6-rtl.css" type="text/css" media="screen" charset="utf-8" />
      <?php endif ?>
    <![endif]-->
  </head>
  <body class="<?php print $body_classes; ?>">
    <div id="fb-root"></div>
    <div id="page">
      <div id="header">
        <?php if ($logo): ?>
        <div id="site-logo">
          <a href="<?php print $base_path; ?>" title="<?php print t('Home'); ?>" rel="home"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" id="logo-image" /></a>
        </div>
        <?php endif; ?>
        <!-- /logo -->
		
        <div id="site-details">          
          <?php if ($main_nav): ?>
          <div id="main-nav">
            <?php print $main_nav; ?>
          </div>
        <?php endif; ?>
        <!-- /main-nav -->       
		</div>
        <!-- /site-details -->
        
		<?php if ($header): ?>
          <div id="header-blocks">
            <?php print $header; ?>
          </div>
        <?php endif; ?>
        <!-- /header-blocks -->
        
		
      </div>
      <!-- /header -->
	  
      <div id="header-sub">
            <?php if ($title || $class): ?>
                <h1 id="title">
                    <span class="title-class"><?php print $class; ?></span><span><?php print $title ?></span>
                </h1>
            <?php endif; ?>
      </div>
      <div id="main">
        <?php if ($sidebar_left): ?>
          <div id="sidebar-left">
            <?php print $sidebar_left; ?>
          </div>
       <?php endif; ?>
        <!-- /sidebar-left -->
        
       <?php if ($sidebar_right): ?>
          <div id="sidebar-right">
            <?php print $sidebar_right; ?>
          </div>
        <?php endif; ?>
        <!-- /sidebar-right -->
        
	<div id="content">

          <?php if ($breadcrumb): ?>
              <?php print $breadcrumb; ?>
          <?php endif; ?>
          
	  <?php if (!empty($content_top)):?>
          <div id="content-top">
          <?php print $content_top; ?>
            </div>
          <?php endif; ?>
          <!-- /content-top -->

          <?php if ($content_background): ?>
            <div id="content-background">
          <?php endif; ?>

          <?php if (!empty($tabs)): ?>
            <div class="tabs">
              <?php print $tabs; ?>
            </div>
          <?php endif; ?>
          <!-- /tabs -->

	  <?php if ($title or $help or $messages): ?>
            <div id="content-header">
              <?php print $messages; ?>
              <?php print $help; ?>
            </div>
          <?php endif; ?>
          <!-- /content-header -->
          
	  <?php if (!empty($content)):?>
            <div id="content-area">
              <?php print $content; ?>
            </div>
          <?php endif; ?>
          <!-- /content -->
          
	  <?php if (!empty($content_bottom)):?>
            <div id="content-bottom">
              <?php print $content_bottom; ?>
            </div>
          <?php endif; ?>
          <!-- /content-bottom -->
          <?php if ($content_background): ?>
            </div>
          <?php endif; ?>

        </div>
      </div>
      <!-- /main -->
      
	  <div id="footer">
          <span id="copyright">Creedia &copy; 2009</span>
        <?php print $footer_message; ?>
      </div>
      <!-- /footer -->
          <?php print $scripts; ?>
	  <?php if ($closure_region): ?>
        <div id="closure-blocks">
          <?php print $closure_region; ?>
        </div>
        <?php endif; ?>
      
    </div>
    <?php print $closure; ?>
    <!-- /page -->
  </body>
</html>
