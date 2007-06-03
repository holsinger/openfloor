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
	<h2>{#PLIGG_Visual_Search_SearchResults#} {$templatelite.get.search|sanitize:2|stripslashes} {$from_text}</h2>
{else}
	<h2>{#PLIGG_Visual_Search_SearchResults#}</h2>
{/if}
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
	{php}
		Global $db, $main_smarty, $page_size, $from_where, $rows, $order_by, $offset, $linksum_sql, $linksum_count, $page_size, $rows;
		include('./libs/link_summary.php');
	{/php}
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>				
	{php}		
		do_pages($rows, $page_size, "search");
	{/php}