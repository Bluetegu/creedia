<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	lang="<?php print $language->language; ?>"
	xml:lang="<?php print $language->language; ?>">
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
	<div id="page">
		<div id="header">
		<?php if ($logo): ?>
			<div id="site-logo">
				<a href="<?php print $base_path; ?>"
					title="<?php print t('Home'); ?>" rel="home"><img
					src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"
					id="logo-image" /> </a>
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

		<div id="front-content">
		<?php if (!empty($content_top)):?>
			<div id="front-content-top">
			<?php print $content_top; ?>
			</div>
			<?php endif; ?>
			<!-- /content-top -->

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

		</div>
		<!-- /main -->

		<div id="footer" class="front-footer">
			<span id="copyright">Creedia &copy; 2009-2011</span>
			<?php print $footer; ?>
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
