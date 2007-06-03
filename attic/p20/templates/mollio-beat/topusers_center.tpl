{php}
	global $db, $dblang, $globals, $main_smarty, $search, $offset, $from_where, $page_size, $top_users_size, $link_id, $items, $order_by, $select;
{/php}	

<h2>{#PLIGG_Visual_TopUsers_Statistics#}</h2>

{php}
echo '<p>&nbsp;</p> <table><tr>';

// Print headers
for($i=0; $i<count($items); $i++) {
	echo '<th class="short">';
	if($i==$sortby) 
		echo '<span class="info_s">'.$items[$i].'</span>';
	else 
		echo '<a href="'.$_SERVER['PHP_SELF'].'?sortby='.$i.'">'.$items[$i].'</a>';
	echo '</th>';
}

echo '<th class="short">'.$main_smarty->get_config_vars('PLIGG_Visual_TopUsers_TH_Karma').'</th>';
echo '</tr>';
$user = new User;
$rows = $db->get_var("SELECT count(*) as count $from_where $order_by");
$users = $db->get_results("$select $from_where $order_by LIMIT $offset,$top_users_size");
if ($users) {
	foreach($users as $dbuser) {
		$user->id=$dbuser->user_id;
		$user->read();
		$user->all_stats();
		
		$main_smarty->assign('user_userlink', getmyurl("user", $user->username));
		$main_smarty->assign('user_username', $user->username);
		$main_smarty->assign('user_total_links', $user->total_links);
		$main_smarty->assign('user_published_links', $user->published_links);
		if($user->total_links>0) 
			$main_smarty->assign('user_published_links_percent', intval($user->published_links/$user->total_links*100));
		else
			$main_smarty->assign('user_published_links_percent', '');
		$main_smarty->assign('user_total_comments', $user->total_comments);
		$main_smarty->assign('user_total_votes', $user->total_votes);
		$main_smarty->assign('user_published_votes', $user->published_votes);
		if($user->total_votes>0) 
			$main_smarty->assign('user_published_votes_percent', intval($user->published_votes/$user->total_votes*100));
		else
			$main_smarty->assign('user_published_votes_percent', '');
		$main_smarty->assign('user_karma', $user->karma);
		$main_smarty->display(The_Template . "/topusers_data.tpl");

	}
}

echo "</table><br />\n\n";

do_pages($rows, $top_users_size, getmyurl("topusers")); // show the "page" buttons at the bottom 


{/php}

