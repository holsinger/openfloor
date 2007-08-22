<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>		
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?= $this->config->site_url();?>" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<style media="all" type="text/css">@import "css/userWindow.css";</style>
	<style type="text/css">
	    <!--
	      @import url('css/wordcloud.css');
	    //-->
	</style>
	<script type="text/javascript" src="javascript/init.js"></script>
	<script type="text/javascript">
		site_url = '<?= $this->config->site_url();?>';
		username = '<?=$this->session->userdata('user_name');?>';
	</script>
	<? if ($browser == 'Internet Explorer' && $browserVer < 7) { ?>
		<style media="all" type="text/css">@import "css/lt7.css";</style>	
		<script type="text/javascript" src="javascript/IEFixes.js"></script>
	<? } ?>
	<script type="text/javascript" src="javascript/lib/prototype.js"></script>
	<script src="javascript/src/scriptaculous.js" type="text/javascript"></script>
	<script src="javascript/src/effects.js" type="text/javascript"></script>
	<script type="text/javascript" src="javascript/userWindow.js"></script>
	<script type="text/javascript" src="javascript/ajaxVideo.js"></script>
	<script type="text/javascript" src="javascript/queueUpdater.js"></script>
	<script type="text/javascript" src="javascript/subcomment.js"></script>
	<script type="text/javascript" src="javascript/clock.js"></script>
	<?php if(isset($this->validation->event_date)) echo @js_calendar_script('my_form');  ?>
	<title>Politic 2.0</title>
	<link rel="icon" href="/p20/favicon.ico" type="image/x-icon"/>
</head>