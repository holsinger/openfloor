<?php $this->config_load("/libs/lang.conf", null, null); ?>
<?php if ($this->_vars['search'] != ""): ?>
	<?php $this->assign('title', $this->_confs['PLIGG_Visual_Search_Header_Search']); ?>
	<?php $this->assign('navbar_where', $this->_confs['PLIGG_Visual_Search_Navbar_Search']); ?>
<?php else: ?>
	<?php $this->assign('title', $this->_confs['PLIGG_Visual_Published_News']); ?>
	<?php $this->assign('navbar_where', $this->_confs['PLIGG_Visual_Published_News']); ?>
<?php endif; ?>

<?php $this->assign('header_id', "home"); ?>

														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
	<?php 
		Global $db, $main_smarty, $page_size, $from_where, $rows, $order_by, $offset, $linksum_sql, $linksum_count, $page_size, $rows;
		include('./libs/link_summary.php'); // this is the code that show the links / stories
	 ?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>				
	<?php 
		do_pages($rows, $page_size, "index"); // show the "page" buttons at the bottom 
		// this will eventually be a smarty include
	 ?>