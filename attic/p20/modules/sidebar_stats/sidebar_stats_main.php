<?php

function sidebar_stats_getdata(){
	global $view, $db, $current_user, $main_smarty;
	
	$members = $db->get_var('SELECT count(*) from ' . table_users . ';');
	$main_smarty->assign('sidebar_stats_members', $members);


	$published = $db->get_var('SELECT count(*) from ' . table_links . ' where link_status = "published";');
	$main_smarty->assign('sidebar_stats_published', $published);

	$queued = $db->get_var('SELECT count(*) from ' . table_links . ' where link_status = "queued";');
	$main_smarty->assign('sidebar_stats_queued', $queued);

	$main_smarty->assign('sidebar_stats_total', $queued + $published);



	$votes = $db->get_var('SELECT count(*) from ' . table_votes . ' where vote_type="links";');
	$main_smarty->assign('sidebar_stats_votes', $votes);

	$comments = $db->get_var('SELECT count(*) from ' . table_comments . ';');
	$main_smarty->assign('sidebar_stats_comments', $comments);
}	


?>