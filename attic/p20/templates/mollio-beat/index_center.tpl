{config_load file="/libs/lang.conf"}
{if $search neq ""}
	{assign var="title" value=#PLIGG_Visual_Search_Header_Search#}
	{assign var="navbar_where" value=#PLIGG_Visual_Search_Navbar_Search#}
{else}
	{assign var="title" value=#PLIGG_Visual_Published_News#}
	{assign var="navbar_where" value=#PLIGG_Visual_Published_News#}
{/if}

{assign var="header_id" value="home"}

{if $setmeka eq "upcoming"}
<div id="grey_tabs">
  <ul>
    <li><a href="{$my_base_url}{$my_pligg_base}"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
  </ul>
</div>
<h2>{#PLIGG_Visual_Pligg_Queued#} </h2>

{else}
<div id="grey_tabs">
  <ul>
    <li><a href="{$URL_upcoming}"><span>{#PLIGG_Visual_Pligg_Queued#} ({$totalupcoming})</span></a></li>
  </ul>
</div>
<h2>{#PLIGG_Visual_Published_News#}</h2>
{/if}


<div id="contents">
    
	
	{if $setmeka eq "upcoming"} 
 	<b>{#PLIGG_Visual_Pligg_Sort_News_By#}:</b>
	{if $paorder eq 1}{#PLIGG_Visual_Pligg_Newest_St#}{else}<a href="index.php?part=upcoming&order=1">{#PLIGG_Visual_Pligg_Newest_St#}</a>{/if} |
	{if $paorder eq 2}{#PLIGG_Visual_Pligg_Oldest_St#}{else}<a href="index.php?part=upcoming&order=2">{#PLIGG_Visual_Pligg_Oldest_St#}</a>{/if} |
	{if $paorder eq 3}{#PLIGG_Visual_Pligg_Most_Pop#}{else}<a href="index.php?part=upcoming&order=3">{#PLIGG_Visual_Pligg_Most_Pop#}</a>{/if} |
	{if $paorder eq 4}{#PLIGG_Visual_Pligg_Least_Pop#}{else}<a href="index.php?part=upcoming&order=4">{#PLIGG_Visual_Pligg_Least_Pop#}</a>{/if}
	{else}
	{if $Voting_Method eq 1}
	<b>{#PLIGG_Visual_Pligg_Sort_News_By#}:</b>
	{if $setmeka eq "" || $setmeka eq "recent"}{#PLIGG_Visual_Recently_Pop#}{else}<a href="{$index_url_recent}">{#PLIGG_Visual_Recently_Pop#}</a>{/if} |
	{if $setmeka eq "today"}{#PLIGG_Visual_Top_Today#}{else}<a href="{$index_url_today}">{#PLIGG_Visual_Top_Today#}</a>{/if} |
	{if $setmeka eq "yesterday"}{#PLIGG_Visual_Yesterday#}{else}<a href="{$index_url_yesterday}">{#PLIGG_Visual_Yesterday#}</a>{/if} |
	{if $setmeka eq "week"}{#PLIGG_Visual_This_Week#}{else}<a href="{$index_url_week}">{#PLIGG_Visual_This_Week#}</a>{/if} |
	{if $setmeka eq "month"}{#PLIGG_Visual_This_Month#}{else}<a href="{$index_url_month}">{#PLIGG_Visual_This_Month#}</a>{/if}
	{/if}
	{/if}


	{php}
		Global $db, $main_smarty, $page_size, $from_where, $rows, $order_by, $offset, $linksum_sql, $linksum_count;
		include('./libs/link_summary.php'); // this is the code that show the links / stories
	{/php}

	{php}
		Global $page_size, $rows;
		do_pages($rows, $page_size, getmyurl("root")); // show the "page" buttons at the bottom 
		// this will eventually be a smarty include
	{/php}

</div>