<div id="grey_tabs">
  <ul>
    <li><a href="{$my_base_url}{$my_pligg_base}"><span>{#PLIGG_Visual_Published_News#}</span></a></li>
  </ul>
</div>


<h2 style="border-bottom:1px solid #ccc; padding-top:5px;">{$page_header}</h2>

{php}
	global $db, $dblang, $globals, $main_smarty, $search, $offset, $from_where, $page_size, $link_id, $linksum_sql, $linksum_count;

echo '<div id="contents">';

{/php}
    {if $Voting_Method eq 1}
    <b>{#PLIGG_Visual_Pligg_Sort_News_By#}:</b>
	{if $paorder eq "" || $paorder eq "newest"}{#PLIGG_Visual_Pligg_Newest_St#}{else}<a href="{$upcoming_url_newest}">{#PLIGG_Visual_Pligg_Newest_St#}</a>{/if} |
	{if $paorder eq "oldest"}{#PLIGG_Visual_Pligg_Oldest_St#}{else}<a href="{$upcoming_url_oldest}">{#PLIGG_Visual_Pligg_Oldest_St#}</a>{/if} |
	{if $paorder eq "mostpopular"}{#PLIGG_Visual_Pligg_Most_Pop#}{else}<a href="{$upcoming_url_mostpopular}">{#PLIGG_Visual_Pligg_Most_Pop#}</a>{/if} |
	{if $paorder eq "leastpopular"}{#PLIGG_Visual_Pligg_Least_Pop#}{else}<a href="{$upcoming_url_leastpopular}">{#PLIGG_Visual_Pligg_Least_Pop#}</a>{/if}
    {/if}
{php} 

	include('./libs/link_summary.php'); // this is the code that show the links / stories
echo '</div><br /><br />';

do_pages($rows, $page_size, "upcoming"); // show the "page" buttons at the bottom 

{/php}