{config_load file="/libs/lang.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	{include file="meta.tpl"}
	
	
    <link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/main.css" media="screen" />
	
	{if $Voting_Method eq 2}
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/star_rating/star_rating.css" media="screen" />
	{/if}	
	
	{if $enable_categorycolors eq 'true'}
    <link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/catcolors.css" media="screen" />
  	{/if}
	
	<script src="{$my_pligg_base}/js/jspath.php" type="text/javascript"></script>
	
	{checkForCss}
	{checkForJs}
	
	<script src="{$my_pligg_base}/templates/{$the_template}/js/behaviour.js{if $enable_gzip_files eq 'true'}.gz{/if}"></script>
	
    <script src="{$my_pligg_base}/templates/{$the_template}/js/misc.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"></script>
		
	<script src="{$my_pligg_base}/templates/{$the_template}/js/tooltip-v0.1.js{if $enable_gzip_files eq 'true'}.gz{/if}" type="text/javascript"> </script>
    
	<script type="text/javascript">
	 preload('{$my_pligg_base}/templates/{$the_template}/images/nav-active.gif','{$my_pligg_base}/templates/{$the_template}/images/vote-active.gif');
	</script>

	<script src="{$my_pligg_base}/templates/{$the_template}/js/sidebarfx.js{if $enable_gzip_files eq 'true'}.gz{/if}"></script>	
	
	<!--[if IE 7]>	
    <link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/ie7.css" media="screen" />
    <![endif]-->

   <!--[if lte IE 6]>
    <script type="text/javascript">
    if (typeof blankImg == 'undefined') var blankImg = '{$my_pligg_base}/templates/{$the_template}/images/blank.gif';
	</script>
    <style type="text/css" media="screen">
    body {literal}{{/literal}behavior:url({$my_pligg_base}/templates/{$the_template}/css/iehfix.htc); {literal}}{/literal}
	#header a#logo {literal}{{/literal}behavior:url({$my_pligg_base}/templates/{$the_template}/css/iepngfix.htc);
	{literal}}{/literal}
	#footer {literal}{{/literal}position:relative; {literal}}{/literal}
    </style>	
    <![endif]-->
	
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
		
		<script src="{$my_pligg_base}/js/xmlhttp.php" type="text/javascript"></script>



		
</head>
<body {$body_args}>
<div id="wrapper">
	
		<div id="header">
	     {include file=$tpl_header.".tpl"}
		</div>
  
    <div id="content">
		<div id="sidebar">
 	 	 {include file=$tpl_right_sidebar.".tpl"}
		</div>
				
        <div id="main">
			<div id="breadcrumb">
		  		{if $navbar_where.show neq "no"}
		    		<a href = "{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Breadcrumb_SiteName#}{#PLIGG_Visual_Breadcrumb_Home#}</a>
		    		{if $navbar_where.link1 neq ""} &#187; <a href="{$navbar_where.link1}">{$navbar_where.text1}</a>{elseif $navbar_where.text1 neq ""} &#187; {$navbar_where.text1}{/if}
		    		{if $navbar_where.link2 neq ""} &#187; <a href="{$navbar_where.link2}">{$navbar_where.text2}</a>{elseif $navbar_where.text2 neq ""} &#187; {$navbar_where.text2}{/if}      	
		    		{if $navbar_where.link3 neq ""} &#187; <a href="{$navbar_where.link3}">{$navbar_where.text3}</a>{elseif $navbar_where.text3 neq ""} &#187; {$navbar_where.text3}{/if}      	
		    		{if $navbar_where.link4 neq ""} &#187; <a href="{$navbar_where.link4}">{$navbar_where.text4}</a>{elseif $navbar_where.text4 neq ""} &#187; {$navbar_where.text4}{/if}      	
		  		{/if}
	    	</div>	      
			
			{checkActionsTpl location="tpl_pligg_above_center"}
			
	    	{include file=$tpl_center.".tpl"}
			
			{checkActionsTpl location="tpl_pligg_below_center"}
			
    	</div>
	
	   <br clear="all" />
 	</div> <!-- content end --> 
     
	<div id="footer">
	 {include file=$tpl_footer.".tpl"}
	</div>
</div><!-- wrapper end -->	

 {checkActionsTpl location="tpl_footer"}

</body>
</html>