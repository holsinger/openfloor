<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'comment.php');

$comment = new Comment;
$comment->id=$_POST['id'];
$comment->read();

if ($current_user->user_id == 0 && !anonnymous_vote) {
	error(_(PLIGG_Visual_Menealo_NoAnon));
}

if($current_user->user_id != $_POST['user']) {
	error(_(PLIGG_Visual_Menealo_BadUser). $current_user->user_id . '-'. $_POST['user']);
}

$md5=md5($_POST['user'].$comment->randkey);
if($md5 !== $_POST['md5']){
	error(_(PLIGG_Visual_Menealo_BadKey));
}

if($comment->votes($current_user->user_id) <> 0) {
	error(_(PLIGG_Visual_Menealo_AlreadyVoted));
}

$value = $_POST['value'];

$votes = $comment->insert_vote($current_user->user_id, $value);

$comment->votes = $votes;
$comment->store();

$count=$comment->votes;
echo "$count ~--~".$_POST['id'];

function error($mess) {
	header('Content-Type: text/plain; charset=UTF-8');
	echo "ERROR: $mess";
	die;
}
?>