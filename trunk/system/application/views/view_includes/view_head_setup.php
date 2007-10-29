<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>		
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?= $this->config->site_url();?>" />
	<link rel="icon" href="/p20/favicon.ico" type="image/x-icon"/>
	<?
	if(isset($rss))
		foreach($rss as $feed)
			echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$feed['title']}\" href=\"{$feed['href']}\" />\n";
	?>

	<!-- 
	
	CSS DEPENDENCIES
	#dependency /all2.css
	#dependency /userWindow.css
	#dependency /flag.css
	#dependency /wordcloud.css
	
	JAVASCRIPT DEPENDENCIES
	#dependency /init.js
	#dependency /lib/prototype.js
	#dependency /src/scriptaculous.js
	#dependency /src/effects.js
	#dependency /userWindow.js
	
	-->

	<? if ($browser == 'Internet Explorer' && $browserVer < 7): ?>
	<style media="all" type="text/css">@import "css/lt7.css";</style>	
	<script type="text/javascript" src="javascript/IEFixes.js"></script>
	<? endif: ?>

	<script type="text/javascript">
		site_url = '<?= $this->config->site_url();?>';
		username = '<?=$this->userauth->user_name;?>';
	</script>
	<?php if(isset($this->validation->event_date)) echo @js_calendar_script('my_form');  ?>
	<title>RunPolitics</title>
</head>