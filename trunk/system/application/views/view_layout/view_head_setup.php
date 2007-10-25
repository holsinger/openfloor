<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<base href="<?= $this->config->site_url();?>" />
<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
<?
if(isset($rss)): 
	foreach($rss as $feed):
		echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$feed['title']}\" href=\"{$feed['href']}\" />\n";
	endforeach;
endif;
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Run Politics</title>
	<!-- 
	
	CSS DEPENDENCIES
	#dependency all2.css
	#dependency main.css
	#dependency userWindow.css
	#dependency flag.css
	#dependency wordcloud.css
	
	JAVASCRIPT DEPENDENCIES
	#dependency init.js
	#dependency /lib/prototype.js
	#dependency /src/scriptaculous.js
	#dependency /src/effects.js
	#dependency userWindow.js
	#dependency ajaxVideo.js
	#dependency queueUpdater.js
	#dependency clock.js
	
	-->
	
	<!-- DO NOT REMOVE THIS LINE -->
	<!-- #dependencies -->
	
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="css/ie6.css" /><![endif]-->
	<!--[if gt IE 6]><link rel="stylesheet" type="text/css" href="css/ie7.css" /><![endif]-->

	<script type="text/javascript">
		site_url = '<?= $this->config->site_url();?>';
		username = '<?=$this->userauth->user_name;?>';
	</script>	
	<?= isset($this->validation->event_date) ? @js_calendar_script('my_form') : '' ; ?>
</head>