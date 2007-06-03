{config_load file="/libs/lang.conf"}

<ul class="search2">
	<form action="{$my_base_url}{$my_pligg_base}/search.php" method="get" name="thisform" id="thisform">
		{if $templatelite.get.search neq ""}
			{assign var=searchboxtext value=$templatelite.get.search|sanitize:2}
		{else}
			{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
		{/if}
		<input type="text" size="15" name="search" id="searchsite" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}"/>
		<input type="submit" value="{#PLIGG_Visual_Search_Go#}" class="submit" />
	</form>
</ul>

<div id="headbar" style="padding-bottom:2px;">
	<ul>
		{if $user_authenticated eq true}
			{#PLIGG_Visual_Welcome_Back#} {$user_logged_in}!&nbsp;&nbsp;
			{if $isadmin eq 1} <a href="{$URL_admin}"> {#PLIGG_Visual_Header_AdminPanel#}</a> &nbsp;&nbsp; {/if}		
			<a href='{$my_base_url}{$my_pligg_base}'>{#PLIGG_Visual_Home#}</a> &nbsp;&nbsp;
			<a href="{$URL_userNoVar}"> {#PLIGG_Visual_Profile#}</a> &nbsp;&nbsp;
			{checkActionsTpl location="tpl_sidebar_logged_in_just_below_profile"} &nbsp;&nbsp;
			{if $Enable_Live eq 'false'} <a href='{$URL_live}'> {#PLIGG_Visual_Live#}</a> &nbsp;&nbsp; {/if}
			<a href='{$URL_topusers}'> {#PLIGG_Visual_Top_Users#}</a> &nbsp;&nbsp;
			{if $Enable_Tags eq 'true'}<a href="{$URL_tagcloud}">{#PLIGG_Visual_Tags#}</a> &nbsp;&nbsp; {/if}
			{if $user_authenticated eq true} <a href="{$URL_logout}"> {#PLIGG_Visual_Logout#}</a>{/if}
		{else}
			<a href='{$my_base_url}{$my_pligg_base}'>{#PLIGG_Visual_Home#}</a> &nbsp;&nbsp;
			<a href='{$URL_login}'>{#PLIGG_Visual_Login_Title#}</a> &nbsp;&nbsp;
			{if $Enable_Live eq 'false'} <a href='{$URL_live}'> {#PLIGG_Visual_Live#}</a> &nbsp;&nbsp; {/if}
			<a href='{$URL_topusers}'> {#PLIGG_Visual_Top_Users#}</a> &nbsp;&nbsp;
			{if $Enable_Tags eq 'true'}<a href="{$URL_tagcloud}">{#PLIGG_Visual_Tags#}</a> &nbsp;&nbsp; {/if}
		{/if}
	</ul>
</div>

<br/>

<div id="cab">
	<ul class="postin">
		{if $pagename eq "upcoming"}
		    <li><a href="{$my_base_url}{$my_pligg_base}" class="navbut3"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
		    <li><a href="{$URL_upcoming}" class="navbut4"><span>{#PLIGG_Visual_Pligg_Queued#}</span></a></li>
		    <li><a href="{$URL_submit}" class="navbut3"><span>{#PLIGG_Visual_Submit_A_New_Story#}</span></a></li>
		{elseif $pagename eq "index"}
		    <li><a href="{$my_base_url}{$my_pligg_base}" class="navbut4"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
		    <li><a href="{$URL_upcoming}" class="navbut3"><span>{#PLIGG_Visual_Pligg_Queued#}</span></a></li>
		    <li><a href="{$URL_submit}" class="navbut3"><span>{#PLIGG_Visual_Submit_A_New_Story#}</span></a></li>
		{elseif $pagename eq "submit"}
		    <li><a href="{$my_base_url}{$my_pligg_base}" class="navbut3"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
		    <li><a href="{$URL_upcoming}" class="navbut3"><span>{#PLIGG_Visual_Pligg_Queued#}</span></a></li>
		    <li><a href="{$URL_submit}" class="navbut4"><span>{#PLIGG_Visual_Submit_A_New_Story#}</span></a></li>
		{else}
	    	<li><a href="{$my_base_url}{$my_pligg_base}" class="navbut3"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
		    <li><a href="{$URL_upcoming}" class="navbut3"><span>{#PLIGG_Visual_Pligg_Queued#}</span></a></li>
		    <li><a href="{$URL_submit}" class="navbut3"><span>{#PLIGG_Visual_Submit_A_New_Story#}</span></a></li>   
		{/if}
	</ul>
</div>

<div id="navbar">
	<ul>
		{#PLIGG_Visual_Breadcrumb_Your_Location#}: <a href = "{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Breadcrumb_SiteName#} {#PLIGG_Visual_Breadcrumb_Home#}</a>
		{if $navbar_where.link1 neq ""} &#187; <a href="{$navbar_where.link1}">{$navbar_where.text1}</a>{elseif $navbar_where.text1 neq ""} &#187; {$navbar_where.text1}{/if}
		{if $navbar_where.link2 neq ""} &#187; <a href="{$navbar_where.link2}">{$navbar_where.text2}</a>{elseif $navbar_where.text2 neq ""} &#187; {$navbar_where.text2}{/if}      	
		{if $navbar_where.link3 neq ""} &#187; <a href="{$navbar_where.link3}">{$navbar_where.text3}</a>{elseif $navbar_where.text3 neq ""} &#187; {$navbar_where.text3}{/if}      	
		{if $navbar_where.link4 neq ""} &#187; <a href="{$navbar_where.link4}">{$navbar_where.text4}</a>{elseif $navbar_where.text4 neq ""} &#187; {$navbar_where.text4}{/if}      	
	</ul> 
			 	   
	<ul id="sorts">
		{if $pagename eq "upcoming"}
			{#PLIGG_Visual_Pligg_Sort_News_By#}:
			{if $paorder eq "" || $paorder eq "newest"}{#PLIGG_Visual_Pligg_Newest_St#}{else}<a href="{$upcoming_url_newest}">{#PLIGG_Visual_Pligg_Newest_St#}</a>{/if} | 
			{if $paorder eq "oldest"}{#PLIGG_Visual_Pligg_Oldest_St#}{else}<a href="{$upcoming_url_oldest}">{#PLIGG_Visual_Pligg_Oldest_St#}</a>{/if} | 
			{if $paorder eq "mostpopular"}{#PLIGG_Visual_Pligg_Most_Pop#}{else}<a href="{$upcoming_url_mostpopular}">{#PLIGG_Visual_Pligg_Most_Pop#}</a>{/if} | 
			{if $paorder eq "leastpopular"}{#PLIGG_Visual_Pligg_Least_Pop#}{else}<a href="{$upcoming_url_leastpopular}">{#PLIGG_Visual_Pligg_Least_Pop#}</a>{/if} |
			<a href="{$URL_rss2queued}" target="_blank"><img src="{$my_pligg_base}/templates/yget/images/rss.gif"></a>
		{elseif $pagename neq "story"}
			{if $Voting_Method eq 1}
			{#PLIGG_Visual_Pligg_Sort_News_By#}:
			{if $setmeka eq "" || $setmeka eq "recent"}{#PLIGG_Visual_Recently_Pop#}{else}<a href="{$index_url_recent}">{#PLIGG_Visual_Recently_Pop#}</a>{/if} | 
			{if $setmeka eq "today"}{#PLIGG_Visual_Top_Today#}{else}<a href="{$index_url_today}">{#PLIGG_Visual_Top_Today#}</a>{/if} | 
			{if $setmeka eq "yesterday"}{#PLIGG_Visual_Yesterday#}{else}<a href="{$index_url_yesterday}">{#PLIGG_Visual_Yesterday#}</a>{/if} | 
			{if $setmeka eq "week"}{#PLIGG_Visual_This_Week#}{else}<a href="{$index_url_week}">{#PLIGG_Visual_This_Week#}</a>{/if} | 
			{if $setmeka eq "month"}{#PLIGG_Visual_This_Month#}{else}<a href="{$index_url_month}">{#PLIGG_Visual_This_Month#}</a>{/if} | 
		{/if}
			<a href="{$URL_rss2}" target="_blank"><img src="{$my_pligg_base}/templates/yget/images/rss.gif"></a>
		{/if}		
	</ul>
</div>