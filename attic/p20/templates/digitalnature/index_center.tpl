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
         <h2>{#PLIGG_Visual_Pligg_Queued#} </h2>
 	  	 <div class="tabs" style="border:none;">
 	  	   <ul>
 	  	     <li><a href="{$my_base_url}{$my_pligg_base}"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
 	  	   </ul>
 	  	 </div>	  	 
 	  	 
{else}
		  <h2>{#PLIGG_Visual_Published_News#}</h2>
 	  	  <div class="tabs" style="margin-top:-50px; border:none;">
 	  	   <ul>
 	  	     <li><a href="{$URL_upcoming}"><span>{#PLIGG_Visual_Pligg_Queued#} ({$totalupcoming})</span></a></li>
			 
			{if $Voting_Method eq 1}	
	
			{if $setmeka eq "month"}<li class="active"><a><span>{#PLIGG_Visual_This_Month#}</span></a></li>{else}<li><a href="{$index_url_month}"><span>{#PLIGG_Visual_This_Month#}</span></a></li>{/if}
			{if $setmeka eq "week"}<li class="active"><a><span>{#PLIGG_Visual_This_Week#}</span></a></li>{else}<li><a href="{$index_url_week}"><span>{#PLIGG_Visual_This_Week#}</span></a></li>{/if}
		{if $setmeka eq "yesterday"}<li class="active"><a><span>{#PLIGG_Visual_Yesterday#}</span></a></li>{else}<li><a href="{$index_url_yesterday}"><span>{#PLIGG_Visual_Yesterday#}</span></a></li>{/if}
		 {if $setmeka eq "today"}<li class="active"><a><span>{#PLIGG_Visual_Top_Today#}</span></a></li>{else}<li><a href="{$index_url_today}"><span>{#PLIGG_Visual_Top_Today#}</span></a></li>{/if}
		 {if $setmeka eq "" || $setmeka eq "recent"}<li class="active"><a><span>{#PLIGG_Visual_Recently_Pop#}</span></a></li>{else}<li><a href="{$index_url_recent}"><span>{#PLIGG_Visual_Recently_Pop#}</span></a></li>{/if}
			{/if}		 
			 
 	  	   </ul>
 	  	 </div>
 	  	
{/if}

<div style="margin-top:-20px; padding-bottom:20px;">

  {if $setmeka eq "upcoming"}
 	<b>{#PLIGG_Visual_Pligg_Sort_News_By#}:</b>
 	{if $paorder eq 1}{#PLIGG_Visual_Pligg_Newest_St#}{else}<a href="index.php?part=upcoming&order=1">{#PLIGG_Visual_Pligg_Newest_St#}</a>{/if} |
 	{if $paorder eq 2}{#PLIGG_Visual_Pligg_Oldest_St#}{else}<a href="index.php?part=upcoming&order=2">{#PLIGG_Visual_Pligg_Oldest_St#}</a>{/if} |
 	{if $paorder eq 3}{#PLIGG_Visual_Pligg_Most_Pop#}{else}<a href="index.php?part=upcoming&order=3">{#PLIGG_Visual_Pligg_Most_Pop#}</a>{/if} |
	{if $paorder eq 4}{#PLIGG_Visual_Pligg_Least_Pop#}{else}<a href="index.php?part=upcoming&order=4">{#PLIGG_Visual_Pligg_Least_Pop#}</a>{/if}
 {else}

 {/if}
 
 </div>


<div id="contents">

{php}
Global $db, $dblang, $search, $main_smarty, $page_size, $from_where, $rows, $order_by, $offset, $linksum_sql, $linksum_count, $link_id;

include('./libs/link_summary.php'); // this is the code that show the links / stories

do_pages($rows, $page_size, "index"); // show the "page" buttons at the bottom 
{/php}

</div>