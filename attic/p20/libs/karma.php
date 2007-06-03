<?php
include('../config.php');
include(mnminclude.'user.php');

header("Content-Type: text/plain");

$karma_base=10;
$min_karma=6;
$max_karma=20;
$negative_per_day = 0.3;
$history_from = time() - 3600*24*7;
$points_link_users = 6;
$points_vote_users = 10;

/////////////////////////
$total_links = $db->get_var("SELECT count(*) from " . table_links . "  WHERE link_date > FROM_UNIXTIME($history_from)  and link_status != 'discard'");
$total_published = $db->get_var("SELECT count(*) from " . table_links . " WHERE link_date > FROM_UNIXTIME($history_from)  and link_status = 'published'");

$total_votes = $db->get_var("SELECT count(*) from " . table_votes . "  WHERE vote_date > FROM_UNIXTIME($history_from)");
$total_published_votes = $db->get_var("SELECT count(*) from " . table_votes . ", " . table_links . "  WHERE vote_date > FROM_UNIXTIME($history_from) and vote_link_id = link_id and link_status = 'published' and vote_date < link_published_date");


$total_links_users = $db->get_var("select count(*) from " . table_users . ", " . table_links . " where link_date > FROM_UNIXTIME($history_from) and link_status != 'discard' and user_id = link_author");

echo "Total link users: $total_links_users\n";
echo "Links: $total_links, Published: $total_published\n";
echo "Votes: $total_votes, Published: $total_published_votes\n";



///////////////////////
$query = $db->get_row("SELECT count(*) as articles, user_id from " . table_links . ", " . table_users . " WHERE link_date > FROM_UNIXTIME($history_from) and link_author=user_id and link_status = 'published' group by user_id order by articles desc limit 1");
$max_published = $query->articles;

$query = $db->get_row("SELECT count(*) as votes, user_id from " . table_votes . ", " . table_users . ", " . table_links . " WHERE vote_date > FROM_UNIXTIME($history_from) and vote_user_id=user_id and link_id = vote_link_id and link_status = 'published' and vote_date < link_published_date group by user_id order by votes desc limit 1");
$max_published_vote = $query->votes;


echo "MAX Votes = $max_published_vote\n";



$link_published_coef = $total_published / $max_published;
$link_published_votes_coef = $total_published_votes / $max_published_vote;
$avg_published_votes = .66*($total_published_votes/$total_votes);


echo "AVG published votes: $avg_published_votes\n";

$users = $db->get_results("SELECT user_id from " . table_users . " order by user_login");

foreach($users as $dbuser) {
	$user = new User;
	$user->id=$dbuser->user_id;
	$user->read();
	$user->all_stats($history_from);

	if($user->total_links > 0) 
		$pnot = ($user->total_links-$user->published_links)/($user->total_links);
	else $pnot = 0;
	$ppub = $user->published_links/$total_published;
	$karma_1 = -$pnot*$points_link_users/5 +  $ppub*$points_link_users*$link_published_coef;
//	echo $user->username . " $pnot, $ppub = $karma_1\n";


	if($user->total_votes > 0) 
		$pnot = $user->published_votes/$user->total_votes;
	else $pnot = 0;
//	$ppub = $user->published_votes/$total_published_votes;
	$karma_2 = ($pnot-$avg_published_votes)*$points_vote_users*($user->published_votes/$max_published_vote);


	$karma_3 = 0;
	if ($user->date < time()-86400*2) {
		$past_time=time() - $db->get_var("select UNIX_TIMESTAMP(max(vote_date)) from " . table_votes . " where vote_user_id=$dbuser->user_id");
		$karma_3 = - min($past_time*$negative_per_day/(3600*24), 4);
	}
	$karma = max($karma_base+$karma_1+$karma_2+$karma_3, $min_karma);
	$karma = min($karma, $max_karma);
	echo $user->username . ": $karma\n";
	$user->karma = $karma;
	$user->store();


}
?>