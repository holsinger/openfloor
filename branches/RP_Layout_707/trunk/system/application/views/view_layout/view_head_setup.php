<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<base href="<?= $this->config->site_url();?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Run Politics</title>

<style media="all" type="text/css">@import "css/all2.css";</style>
<style type="text/css" media="screen">
    @import url("css/main.css");
</style>
<style media="all" type="text/css">@import "css/userWindow.css";</style>
	<style media="all" type="text/css">@import "css/flag.css";</style>
<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="css/ie6.css" /><![endif]-->
<!--[if gt IE 6]><link rel="stylesheet" type="text/css" href="public/css/ie7.css" /><![endif]-->
<style type="text/css">
	    <!--
	      @import url('css/wordcloud.css');
	    //-->
	</style>
	<script type="text/javascript" src="javascript/init.js"></script>
<script type="text/javascript">
	site_url = '<?= $this->config->site_url();?>';
	username = '<?=$this->userauth->user_name;?>';
</script>
<script type="text/javascript" src="javascript/lib/prototype.js"></script>
<script src="javascript/src/scriptaculous.js" type="text/javascript"></script>
<script src="javascript/src/effects.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/userWindow.js"></script>
	<script type="text/javascript" src="javascript/ajaxVideo.js"></script>
	<script type="text/javascript" src="javascript/queueUpdater.js"></script>
	<script type="text/javascript" src="javascript/subcomment.js"></script>
	<script type="text/javascript" src="javascript/clock.js"></script>
	<?php if(isset($this->validation->event_date)) echo @js_calendar_script('my_form');  ?>
	<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
	<?
	if(isset($rss)): 
		foreach($rss as $feed):
			echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$feed['title']}\" href=\"{$feed['href']}\" />\n";
		endforeach;
	endif;
	?>
</head>