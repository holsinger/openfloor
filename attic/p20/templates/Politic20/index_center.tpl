{config_load file="/libs/lang.conf"}
{if $search neq ""}
	{assign var="title" value=#PLIGG_Visual_Search_Header_Search#}
	{assign var="navbar_where" value=#PLIGG_Visual_Search_Navbar_Search#}
{else}
	{assign var="title" value=#PLIGG_Visual_Published_News#}
	{assign var="navbar_where" value=#PLIGG_Visual_Published_News#}
{/if}

{assign var="header_id" value="home"}

														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
	{php}
		Global $db, $main_smarty, $page_size, $from_where, $rows, $order_by, $offset, $linksum_sql, $linksum_count, $page_size, $rows;
		include('./libs/link_summary.php'); // this is the code that show the links / stories
	{/php}
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>				
	{php}
		do_pages($rows, $page_size, "index"); // show the "page" buttons at the bottom 
		// this will eventually be a smarty include
	{/php}