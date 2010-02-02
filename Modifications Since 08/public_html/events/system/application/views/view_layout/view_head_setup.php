<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<base href="<?= $this->config->site_url();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
	<title><?= $this->config->item('custom_title');?></title>
	<?
	if(isset($rss))
		foreach($rss as $feed)
			echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$feed['title']}\" href=\"{$feed['href']}\" />\n";
	?>
	<?
	// This will bring in any addition code as needed in the head section.  The RSS stuff should be merged to use this since it's more dynamic - CTE
	foreach($head_include as $h_view):?>
		<?="<!--dynamically included $h_view-->"?>
		<?$this->load->view('view_head_includes/'.$h_view);?>
	<?endforeach;?>
	<!-- 
	CSS DEPENDENCIES	
	#dependency lightview.css		
	
	JAVASCRIPT DEPENDENCIES
	#dependency init.js
	#dependency ajaxVideo.js
	#dependency queueUpdater.js
	#dependency clock.js
	#dependency effects.js
	#dependency lightview.js
	#dependency userWindow.js
	-->
	
	<script src="./javascript/protoculous.js" type="text/javascript"></script>
	
	<script type="text/javascript" charset="utf-8"><?= isset($js) ? $js : '' ?></script>
	<!-- DO NOT REMOVE THIS LINE -->
	<!-- #dependencies -->
	
	<script type="text/javascript">
		site_url = '<?= $this->config->site_url();?>';
		username = '<?=$this->userauth->user_name;?>';
	</script>
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="<?= $this->config->site_url() ?>css/lt7.css" /><![endif]-->
	
    
	<?= isset($this->validation->event_date) ? @js_calendar_script('my_form') : '' ; ?>
</head>