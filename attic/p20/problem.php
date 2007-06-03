<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'link.php');
include(mnminclude.'votes.php');

/*
echo $_SERVER['REQUEST_URI'];
exit;
*/


$link = new Link;
$id=$_REQUEST['id'];
$user_id=$_REQUEST['user'];



$value = intval($_REQUEST['value']);
if ($value < -10 || $value > -1)
	error(_(PLIGG_Visual_Problem_BadVote) . " $value");

$link->id=$id;
$link->read_basic();

if($current_user->user_id != $_REQUEST['user']) {
	error(_(PLIGG_Visual_Problem_BadUser). $current_user->user_id . '-'. $_REQUEST['user']);
}

$md5=md5($_REQUEST['user'].$link->randkey);
if($md5 !== $_REQUEST['md5']){
	error(_(PLIGG_Visual_Problem_BadKey));
}

$vote = new Vote;
$vote->link=$link->id;
$vote->type='links';
$vote->user=$user_id;
$count=$vote->count('< 0');

if($count > 0)
	error(_(PLIGG_Visual_Problem_AlreadyVoted));

$vote->value = $value;
if(!$vote->insert()) {
	error(_(PLIGG_Visual_Problem_ErrorInserting));
}

echo _(PLIGG_Visual_Problem_OkThanks);

function error($mess) {
	echo "$mess";
	die;
}
?>