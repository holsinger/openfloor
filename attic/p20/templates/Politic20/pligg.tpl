{config_load file="/libs/lang.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	{include file="meta.tpl"}
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style media="all" type="text/css">@import "{$my_pligg_base}/templates/{$the_template}/css/all.css";</style>
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/lt7.css" media="screen"/><![endif]-->
	<script src="{$my_pligg_base}/templates/{$the_template}/js/misc.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"></script>
	<script src="{$my_pligg_base}/templates/{$the_template}/js/toggle.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javaScript"></script> 

	{checkForCss}
	{checkForJs}		
		
	{if $Spell_Checker eq 1}			
	<script src="{$my_pligg_base}/3rdparty/speller/spellChecker.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"></script>
	{literal}
	<script type="text/javascript">
		 function openSpellChecker(commentarea) {
			   var txt = document.getElementById(commentarea);
			   var speller = new spellChecker( txt );
			   speller.openChecker();
			}
	</script>
	{/literal}
	{/if}	
	
	{literal}
	<script type="text/javascript">
	<!--
		function show_hide_user_links(thediv)
		{
			if(window.Effect){
				if(thediv.style.display == 'none')
				{Effect.Appear(thediv); return false;}
				else
				{Effect.Fade(thediv); return false;}
			}else{
				var replydisplay=thediv.style.display ? '' : 'none';
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
	{/literal}
	
	{checkActionsTpl location="tpl_pligg_pre_title"}
	
	<title>{$pretitle}{#PLIGG_Visual_Name#}{$posttitle}</title>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://{$server_name}{$my_pligg_base}/rss2.php"/>
	<link rel="icon" href="{$my_pligg_base}/favicon.ico" type="image/x-icon"/>
	<script src="{$my_pligg_base}/js/jspath.php" type="text/javascript"></script>
	<script src="{$my_pligg_base}/js/xmlhttp.php" type="text/javascript"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/navigation.js"></script>
</head>
<body>
		{include file=$tpl_header.".tpl"}
												<div id="twocolumn">
													<!-- right column start here -->
													<div id="right">
														{include file=$tpl_right_sidebar.".tpl"}
													</div>
													<div class="main-box">
														{include file=$tpl_center.".tpl"}
													</div>
												</div>
		{include file=$tpl_footer.".tpl"}
</body>
</html>