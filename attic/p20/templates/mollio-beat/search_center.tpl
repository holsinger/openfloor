{config_load file="/libs/lang.conf"}
{if $templatelite.get.search neq ""}
	{assign var="title" value=#PLIGG_Visual_Search_Header_Search#}
	{assign var="navbar_where" value=#PLIGG_Visual_Search_Navbar_Search#}
{else}
	{assign var="title" value=#PLIGG_Visual_Published_News#}
	{assign var="navbar_where" value=#PLIGG_Visual_Published_News#}
{/if}

{assign var="header_id" value="home"}

{if $templatelite.get.search neq ""}
	<h2>{#PLIGG_Visual_Search_SearchResults#} {$templatelite.get.search|sanitize:2} {$from_text}</h2>
{else}
	<h2>{#PLIGG_Visual_Search_SearchResults#}</h2>
{/if}


<div id="contents">

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

