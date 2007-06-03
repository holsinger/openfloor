<?php require_once('C:\php5\htdocs\p20\plugins\function.checkActionsTpl.php'); $this->register_function("checkActionsTpl", "tpl_function_checkActionsTpl");  require_once('C:\php5\htdocs\p20\plugins\function.checkForJs.php'); $this->register_function("checkForJs", "tpl_function_checkForJs");  require_once('C:\php5\htdocs\p20\plugins\function.checkForCss.php'); $this->register_function("checkForCss", "tpl_function_checkForCss");  $this->config_load("/libs/lang.conf", null, null); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("meta.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style media="all" type="text/css">@import "<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/css/all.css";</style>
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/css/lt7.css" media="screen"/><![endif]-->
	<script src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/js/misc.js<?php if ($this->_vars['enable_gzip_files'] == 'true'): ?>.gz<?php endif; ?>" type="text/javascript"></script>
	<script src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/js/toggle.js<?php if ($this->_vars['enable_gzip_files'] == 'true'): ?>.gz<?php endif; ?>" type="text/javaScript"></script> 

	<?php echo tpl_function_checkForCss(array(), $this);?>
	<?php echo tpl_function_checkForJs(array(), $this);?>		
		
	<?php if ($this->_vars['Spell_Checker'] == 1): ?>			
	<script src="<?php echo $this->_vars['my_pligg_base']; ?>
/3rdparty/speller/spellChecker.js<?php if ($this->_vars['enable_gzip_files'] == 'true'): ?>.gz<?php endif; ?>" type="text/javascript"></script>
	<?php echo '
	<script type="text/javascript">
		 function openSpellChecker(commentarea) {
			   var txt = document.getElementById(commentarea);
			   var speller = new spellChecker( txt );
			   speller.openChecker();
			}
	</script>
	'; ?>

	<?php endif; ?>	
	
	<?php echo '
	<script type="text/javascript">
	<!--
		function show_hide_user_links(thediv)
		{
			if(window.Effect){
				if(thediv.style.display == \'none\')
				{Effect.Appear(thediv); return false;}
				else
				{Effect.Fade(thediv); return false;}
			}else{
				var replydisplay=thediv.style.display ? \'\' : \'none\';
				thediv.style.display = replydisplay;					
			}
		}
	//-->
	</script>	
	
	<script type="text/javascript">
		/***********************************************
		* Bookmark site script-  Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* This notice MUST stay intact for legal use
		* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
		***********************************************/
		function bookmarksite(title, url){
		if (document.all)
		window.external.AddFavorite(url, title);
		else if (window.sidebar)
		window.sidebar.addPanel(title, url, "")
		}
	</script>
	'; ?>

	
	<?php echo tpl_function_checkActionsTpl(array('location' => "tpl_pligg_pre_title"), $this);?>
	
	<title><?php echo $this->_vars['pretitle'];  echo $this->_confs['PLIGG_Visual_Name'];  echo $this->_vars['posttitle']; ?>
</title>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://<?php echo $this->_vars['server_name'];  echo $this->_vars['my_pligg_base']; ?>
/rss2.php"/>
	<link rel="icon" href="<?php echo $this->_vars['my_pligg_base']; ?>
/favicon.ico" type="image/x-icon"/>
	<script src="<?php echo $this->_vars['my_pligg_base']; ?>
/js/jspath.php" type="text/javascript"></script>
	<script src="<?php echo $this->_vars['my_pligg_base']; ?>
/js/xmlhttp.php" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/js/navigation.js"></script>
</head>
<body>
		<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include($this->_vars['tpl_header'].".tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
												<div id="twocolumn">
													<!-- right column start here -->
													<div id="right">
														<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include($this->_vars['tpl_right_sidebar'].".tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
													</div>
													<div class="main-box">
														<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include($this->_vars['tpl_center'].".tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
													</div>
												</div>
		<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include($this->_vars['tpl_footer'].".tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>