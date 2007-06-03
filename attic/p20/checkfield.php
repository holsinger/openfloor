<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

	include('config.php');
	include(mnminclude.'html1.php');

	$type=sanitize($_REQUEST['type'], 2);
	$name=sanitize($_GET["name"], 2);
	#echo "$type, $name...";
	switch ($type) {
		case 'username':
			if (strlen($name)<3) {
				echo _(PLIGG_Visual_CheckField_UserShort);
				return;
			}
			if (!preg_match('/^[a-z0-9_\-\.@]+$/i', $name)) {
				echo _(PLIGG_Visual_CheckField_InvalidChars);
				return;
			}
			if(user_exists($name)) {
				echo _(PLIGG_Visual_CheckField_UserExists);
				return;
			}
			echo "OK";
			break;
		case 'email':
			if (!check_email($name)) {
				echo _(PLIGG_Visual_CheckField_EmailInvalid);
				return;
			}
			if(email_exists($name)) {
				echo _(PLIGG_Visual_CheckField_EmailExists);
				return;
			}
			echo "OK";
			break;
			default:
				echo "KO $type";
	}
?>