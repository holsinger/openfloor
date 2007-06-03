<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'link.php');

$link = new Link;
$link->id=$_POST['id'];
$link->read_basic();

if ($current_user->user_id == 0 && !anonymous_vote) {
	error(_(PLIGG_Visual_Menealo_NoAnon));
}

if($current_user->user_id != $_POST['user']) {
	error(_(PLIGG_Visual_Menealo_BadUser). $current_user->user_id . '-'. $_POST['user']);
}

$md5=md5($_POST['user'].$link->randkey);
if($md5 !== $_POST['md5']){
	error(_(PLIGG_Visual_Menealo_BadKey));
}

if($link->votes($current_user->user_id) > 0) {
	error(_(PLIGG_Visual_Menealo_AlreadyVoted));
}

$value = $_POST['value'];
$link->insert_vote($current_user->user_id, $value);
// TODO

if ($link->status == 'discard') {
	$link->read();
	$link->status = 'queued';
	$link->store();
}

if(Voting_Method == 1){
	$count=$link->votes;
	echo "$count ~--~".$_POST['id'];
}

if(Voting_Method == 2){

	$link_rating = $link->rating($link->id)/2;
	$rating_width = $link_rating * 25;
	$vote_count = $link->countvotes();
	echo $rating_width . "~" . $link_rating . "~" . $vote_count . "~<li class='one-star-noh'>1</li><li class='two-stars-noh'>2</li><li class='three-stars-noh'>3</li><li class='four-stars-noh'>4</li><li class='five-stars-noh'>5</li>";


}


function error($mess) {
	header('Content-Type: text/plain; charset=UTF-8');
	echo "ERROR: $mess";
	die;
}
?>