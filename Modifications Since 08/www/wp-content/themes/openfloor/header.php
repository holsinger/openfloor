<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php echo str_replace('&raquo;','',wp_title('',false,'')); ?></title>

<!-- leave this for stats -->
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<link rel="shortcut icon" type="image/ico" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<style type="text/css" media="screen"> @import url( <?php bloginfo('stylesheet_url'); ?> );	</style>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>

<body>
<div align="center">
	<div class="page">
		<div class="header">
			<div class="logo"><a href="index.html"><img src="<?php bloginfo('template_directory'); ?>/images/Logo-OpenFloorTechnologies.jpg" width="316" height="93" align="left" border="0" /></a></div>
			<div class="nav"><img src="<?php bloginfo('template_directory'); ?>/images/SpacerClear.gif" width="600" height="60" />
  				<ul>
					<?php wp_list_pages('sort_column=menu_order&depth=1&title_li=');?>
					<? /*<li class="page_item"><a href="<?php echo get_settings('home'); ?>/?page=1" title="Home">Blog</a></li>*/?>
				</ul>
			</div>
		</div>
		<!--Header -->
		<div class="titleBar"><a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/titleBarLeft.jpg" width="78" height="30" align="left"/></a>
			<?/*<h6>Welcome to Open Floor Technologies</h6>*/?>
			<div class="breadcrumb">
			<?php
			if (is_home()) {
				?>
				<img src="<?php bloginfo('template_directory'); ?>/images/breadGrt.jpg" height="30" align="left"/>
				Welcome to OpenFloor Technologies
			<?
			} else {
				if (function_exists('breadcrumb_nav_xt_display'))
				{
				// Display the breadcrumb
				breadcrumb_nav_xt_display();
				}
			}?>
			</div>
		</div>
		<!--Title Bar -->
