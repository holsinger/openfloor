{config_load file="/libs/lang.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	{include file="meta.tpl"}
	
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/main.css" media="screen" />
	
	<!--[if gte IE 6]>
	<style type="text/css" media="screen">	
	#category_rss {literal}{{/literal} display:none {literal}}{/literal}
	</style>	
	<![endif]-->
	
	{if $Voting_Method eq 2}
		<style type="text/css" media="screen">	
		.news-submitted {literal}{{/literal}font-size:85%;margin-bottom:3px;padding-left:4px; color:#999999; margin-left:-70px; {literal}}{/literal}
		.news-body-text {literal}{{/literal}margin:10px 0px 0px 0px; font-size:96%; margin-left:-65px;{literal}}{/literal}
		.news-details {literal}{{/literal}padding-left:4px;margin:0;font-size:85%; margin-left:-70px;{literal}}{/literal}
		</style>
		<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/star_rating/star.css" media="screen" />
	{/if}

	<script src="{$my_pligg_base}/templates/{$the_template}/js/misc.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"></script>
	<script src="{$my_pligg_base}/templates/{$the_template}/js/toggle.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javaScript"></script> 

	{checkForCss}
	{checkForJs}		
		
	{if $Spell_Checker eq 1}			
	<script src="{$my_pligg_base}/3rdparty/speller/spellChecker.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"></script>
	{literal}
	<script language="javascript" type="text/javascript">
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
	
</head>
	<body {$body_args}>
	
		<div id="wrap">
		
			<div id="header">
				{include file=$tpl_header.".tpl"}
			</div><!-- header end -->
			
			<div id="content-wrap2">
		  			  
				<div id="sidebar">
					{include file=$tpl_right_sidebar.".tpl"}
				</div><!-- sidebar end -->
					
					<div id="contentbox">
			
						<div id="inside">
							{checkActionsTpl location="tpl_pligg_above_center"}
							{include file=$tpl_center.".tpl"}
							{checkActionsTpl location="tpl_pligg_below_center"}
						</div><!-- inside end -->
						
					</div><!-- contentbox end -->
				
			</div><!-- content-wrap end --> 
		       	
		</div><!-- wrap end -->

		{include file=$tpl_footer.".tpl"}
			
	</body>
</html>