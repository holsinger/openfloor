<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<base href="<?= $this->config->site_url();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
	<title>Run Politics</title>
	<?
	if(isset($rss))
		foreach($rss as $feed)
			echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$feed['title']}\" href=\"{$feed['href']}\" />\n";
	?>
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="<?= $this->config->site_url() ?>css/ie6.css" /><![endif]-->
	<!--[if gt IE 6]><link rel="stylesheet" type="text/css" href="<?= $this->config->site_url() ?>css/ie7.css" /><![endif]-->
	
	<!-- 
	
	CSS DEPENDENCIES
	#dependency all2.css
	#dependency main.css
	#dependency userWindow.css
	#dependency flag.css
	#dependency wordcloud.css
	
	JAVASCRIPT DEPENDENCIES
	#dependency init.js
	#dependency ajaxVideo.js
	#dependency queueUpdater.js
	#dependency clock.js
	dependency effects.js
	#dependency userWindow.js
	-->
	
	<script src="./javascript/prototype.js" type="text/javascript"></script>
	<script src="./javascript/scriptaculous.js" type="text/javascript"></script>	
	
	<!-- DO NOT REMOVE THIS LINE -->
	<!-- #dependencies -->
	
	<script type="text/javascript">
		site_url = '<?= $this->config->site_url();?>';
		username = '<?=$this->userauth->user_name;?>';
	</script>
	
	<script type="text/javascript" charset="utf-8"><?= isset($js) ? $js : '' ?></script>
	<!--[if lt IE 7]><script src="./javascript/IEFixes.js" type="text/javascript" charset="utf-8"></script><![endif]-->

    
	<?= isset($this->validation->event_date) ? @js_calendar_script('my_form') : '' ; ?>
</head>