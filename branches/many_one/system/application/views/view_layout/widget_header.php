<? 
//set vars the will detemine the head tag 
$data['browser'] = $this->agent->browser();
$data['browserVer'] = $this->agent->version();

//setup onLoad array
if (isset($data['js_onload']) && is_array($data['js_onload'])) {
	$onload = implode('();',$data['js_onload']).'();';
}else{
	$onload = 'init();';
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<base href="<?= $this->config->site_url();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
	<title>Many One</title>
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
	#dependency many_one_globalReset.css
	#dependency many_one_global.css
	
	
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
<body onLoad='<?=$onload;?>'>

      	<div id="container">
    		<div id="content" style="width:96%; margin: 0% 2% 2% 2%;">