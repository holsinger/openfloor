<?php
$debug = 0;

$libGuid = new Guid($debug);
$libVisit = new Visit($debug);
$libZip = new Zip($debug);

## check for cookie, if none exists, drop one
if(!$guid = $libGuid->getGUID())
	$guid = $libGuid->dropGUIDCookie();

## record the visit
if ($first_visit) // see admin_session
	$libVisit->recordVisit(session_id(), $guid);
