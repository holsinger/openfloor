														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
	<?php 
		global $db, $dblang, $globals, $main_smarty, $search, $offset, $from_where, $page_size, $link_id, $linksum_sql, $linksum_count;
		include('./libs/link_summary.php'); // this is the code that show the links / stories
	 ?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>				
	<?php 
		do_pages($rows, $page_size, "upcoming");// show the "page" buttons at the bottom 
	 ?>