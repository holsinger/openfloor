<?php

//instantiate script objects
$guids = new db_table ("p20_guids",1);

//register script variables
$error = false;	//used primarily with password validation
$content = "";	//used primarily with file uploads
$action = "";	//used primarily with file uploads

$guids->setField ("GUID_ID",7,"S");
$guids->setField ("DATE_CREATED",time(),"S");
$guids->setField ("GUID_HASH","hash","S");

$guids->insert();

?>