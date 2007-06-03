<h2>{$page_header}</h2>

<div class="tabs" style="margin-top:-50px; border:none;">
 	<ul>
 	  	<li><a href="{$my_base_url}{$my_pligg_base}"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
		
		{if $Voting_Method eq 1} 	
 	
 	{if $paorder eq "leastpopular"}<li class="active"><a><span>{#PLIGG_Visual_Pligg_Least_Pop#}</span></a></li>{else}<li><a href="{$upcoming_url_leastpopular}"><span>{#PLIGG_Visual_Pligg_Least_Pop#}</span></a></li>{/if}
	{if $paorder eq "mostpopular"}<li class="active"><a><span>{#PLIGG_Visual_Pligg_Most_Pop#}</span></a></li>{else}<li><a href="{$upcoming_url_mostpopular}"><span>{#PLIGG_Visual_Pligg_Most_Pop#}</span></a></li>{/if}
	{if $paorder eq "oldest"}<li class="active"><a><span>{#PLIGG_Visual_Pligg_Oldest_St#}</span></a></li>{else}<li><a href="{$upcoming_url_oldest}"><span>{#PLIGG_Visual_Pligg_Oldest_St#}</span></a></li>{/if}
	{if $paorder eq "" || $paorder eq "newest"}<li class="active"><a><span>{#PLIGG_Visual_Pligg_Newest_St#}</span></a></li>{else}<li><a href="{$upcoming_url_newest}"><span>{#PLIGG_Visual_Pligg_Newest_St#}</span></a></li>{/if}
{/if}
		
 	</ul>
</div>

<div id="contents">

{php}
global $db, $dblang, $globals, $main_smarty, $search, $offset, $from_where, $page_size, $link_id, $linksum_sql, $linksum_count, $rows, $order_by;

include('./libs/link_summary.php'); // this is the code that show the links / stories

do_pages($rows, $page_size, "upcoming"); // show the "page" buttons at the bottom 
{/php}

</div>