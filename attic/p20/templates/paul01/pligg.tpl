{config_load file="/libs/lang.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
		{include file="meta.tpl"}
        
		{if $Voting_Method eq 1}
		<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/main.css" media="screen" />
        {else}
		<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/star_rating/star.css" media="screen" /> 
		<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/star_rating/main.css" media="screen" />
        {/if}

        <link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/print.css" media="print">
		<script src="{$my_pligg_base}/js/jspath.php" type="text/javascript"></script>

		{checkForCss}
		{checkForJs}

		<script language="JavaScript" type="Text/JavaScript" src="{$my_pligg_base}/templates/{$the_template}/js/toggle.js"></script> 
		

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
				if(thediv.style.display == 'none')
				{Effect.Appear(thediv); return false;}
				else
				{Effect.Fade(thediv); return false;}
			}
		//-->
		</script>
		
		
		
		<script type="text/javascript">

			/***********************************************
			* Bookmark site script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
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
	<!--These containers are to fix a bug in the mollio beat template-->
	<div id="container1">
	<div id="container2">
	<div id="container3">
	<div id="container4">

		<div id="wrap">
		
			<div id="header">
				{include file=$tpl_header.".tpl"}
			<!-- header end -->
			
			{if $user_authenticated ne true}<div id="content-wrap1">
		  {else}
		  	{if $cat_url neq ""}<div id="content-wrap2">
		  	{else}<div id="content-wrap3">
		  	{/if}
		  {/if}

			<div id="contentbox">
				<div id="contentbox2">
					<div id="contentbox3">
		
		      <div id="breadcrumb">
		      	{if $navbar_where.show neq "no"}
			      	<a href = "{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Breadcrumb_SiteName#}{#PLIGG_Visual_Breadcrumb_Home#}</a>
				     	{if $navbar_where.link1 neq ""} &#187; <a href="{$navbar_where.link1}">{$navbar_where.text1}</a>{elseif $navbar_where.text1 neq ""} &#187; {$navbar_where.text1}{/if}
			 	     	{if $navbar_where.link2 neq ""} &#187; <a href="{$navbar_where.link2}">{$navbar_where.text2}</a>{elseif $navbar_where.text2 neq ""} &#187; {$navbar_where.text2}{/if}      	
			 	     	{if $navbar_where.link3 neq ""} &#187; <a href="{$navbar_where.link3}">{$navbar_where.text3}</a>{elseif $navbar_where.text3 neq ""} &#187; {$navbar_where.text3}{/if}      	
			 	     	{if $navbar_where.link4 neq ""} &#187; <a href="{$navbar_where.link4}">{$navbar_where.text4}</a>{elseif $navbar_where.text4 neq ""} &#187; {$navbar_where.text4}{/if}      	
			 	    {/if}
			    </div>	
		      
			    <div id="inside">	
			
						{checkActionsTpl location="tpl_pligg_above_center"}

		      	{include file=$tpl_center.".tpl"}
		      	
						{checkActionsTpl location="tpl_pligg_below_center"}
		      	
				  </div><!-- inside end -->
					  
					</div> <!--End #contentbox3-->
				</div> <!--End #contentbox2-->
			</div> <!--End #contentbox-->
			<div id="contentbottom"></div>
				
			</div><!-- content-wrap end --> 
		       	
		</div><!-- wrap end -->
</div>
				<div id="sidebar">
					{include file=$tpl_right_sidebar.".tpl"}
		      
				</div><!-- sidebar end --><div style="clear: both"></div>



<!--Closing the container divs-->
</div>
</div>
</div>
</div>

		{include file=$tpl_footer.".tpl"}

			
	</body>
</html>

