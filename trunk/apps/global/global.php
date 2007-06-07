<?php

## functions
function getGUID()
{
	global $dal;
	
	if (isset($_COOKIE['guid']))
		return $dal->isValidGUID($_COOKIE['guid'])?$_COOKIE['guid']:false;
	else
		return false;
}

function dropGUIDCookie()
{
	global $dal;
	
	/* one year cookie */
	$guid = $dal->newGUID();
	setcookie('guid',$guid,time() + 86400*365);
	return $guid;
}

function recordZip($zip)
{
	global $dal;
	if (isset($_COOKIE['PHPSESSID']) && isset($_COOKIE['guid']))
		$dal->recordZip($zip);
}

function makeDefaultZip($zip)
{
	// could add zip code validation here
	global $dal;
	
	if (isset($_COOKIE['guid']))
		$dal->makeDefaultZip($zip);
}
## entry point
//require_once('./dal/dal.php');

$dal = new dal();

/* if there's no current guid, drop one */
if(!$guid = getGUID())
	$guid = dropGUIDCookie();

	
/* if there's no current session, create one and record it */
/*if ($_COOKIE['PHPSESSID']==null) {
	session_start();
	$dal->recordSession(session_id(), $guid);	
}*/
if ($first_visit)
	$dal->recordSession(session_id(), $guid);

/* Debug */
/*
echo 	'<p style="color: maroon; font-weight: bold">
			**GLOBAL INCLUDED**<br/>
			GUID: ' . $_COOKIE['guid'] . '<br/>
			SESSID: ' . $_COOKIE['PHPSESSID'] .
		'</p>';
*/