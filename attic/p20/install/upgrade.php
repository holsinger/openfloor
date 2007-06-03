<?php
$include='header.php'; if (file_exists($include)) { include_once($include); }
$include='functions.php'; if (file_exists($include)) { include_once($include); }

echo "<h3>Upgrade:</h3>";

$file='../config.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! This is a fatal error."; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes! This is a fatal error."; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! Try renaming 'config2.php' to 'settings.php'"; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes!"; }
elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this file to 777 while editing."; }

$file='../libs/dbconnect.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! This is a fatal error."; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes! This is a fatal error."; }

if (!$errors) {

echo 'This will upgrade the database for Pligg Beta v5.10 and above to the latest version.<br /><br /><b>Note:</b> this is just a database upgrade, you still need to upload the new files.<br />';

//this checks to see if they actually do want to upgrade.
if ($_POST['submit'] != "Yes") {
echo '<p>Are you sure you wish to upgrade you database?</p>
	<form id="form" name="form" method="post">
	<input type="submit" name="submit" value="Yes" />
	</form>';
}
else { //they clicked yes!

$include='../config.php';
if (file_exists($include)) { 
	include_once($include);
	include(mnminclude.'html1.php');
}

echo 'Upgrading Tables...<br />';

include(mnminclude.'ts.php');

//---------------------------------------------------------
// Added in beta 4 (i think)
//---------------------------------------------------------

$fieldexists = checkforfield('public_email', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `public_email` varchar(64) NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_aim', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_aim` varchar(64) NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_msn', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_msn` varchar(64) NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_yahoo', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_yahoo` varchar(64) NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_gtalk', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_gtalk` varchar(64) NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_skype', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_skype` varchar(64) NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_irc', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_irc` varchar(64) NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('last_reset_request', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `last_reset_request` TIMESTAMP NOT NULL ;';
	$db->query($sql);
}

//---------------------------------------------------------


//---------------------------------------------------------
//Added in Beta 5.10
//---------------------------------------------------------
$fieldexists = checkforfield('link_tags', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD FULLTEXT `link_tags` (`link_tags`);';
	$db->query($sql);
}

$tableexists = checkfortable(table_prefix . 'tags');
if (!$tableexists) {
	$sql = "CREATE TABLE `" . table_tags . "` (
  `tag_link_id` int(11) NOT NULL default '0',
  `tag_lang` varchar(4) NOT NULL default 'en',
  `tag_date` timestamp NOT NULL,
  `tag_words` varchar(64) NOT NULL default '',
  UNIQUE KEY `tag_link_id` (`tag_link_id`,`tag_lang`,`tag_words`),
  KEY `tag_lang` (`tag_lang`,`tag_date`)
) TYPE = MyISAM;";
	$db->query($sql);
}
//---------------------------------------------------------

//---------------------------------------------------------
//Added in Beta 6.02
//---------------------------------------------------------

$fieldexists = checkforfield('link_field1', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field1` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field2', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field2` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field3', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field3` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field4', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field4` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field5', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field5` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field6', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field6` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field7', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field7` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field8', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field8` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field9',table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field9` varchar(255) NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field10', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field10` text NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field11', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field11` text NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field12', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field12` text NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field13', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field13` text NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field14', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field14` text NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('link_field15', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_field15` text NULL';
	$db->query($sql);
}



$fieldexists = checkforfield('comment_votes', table_comments);
if (!$fieldexists) {
	$sql = "ALTER TABLE `" . table_comments . "` ADD `comment_votes` int(20) NOT NULL default '0'";
	$db->query($sql);
}
$fieldexists = checkforfield('comment_field1', table_comments);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_comments . '` ADD `comment_field1` varchar(255) default NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('comment_field2', table_comments);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_comments . '` ADD `comment_field2` varchar(255) default NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('comment_field3', table_comments);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_comments . '` ADD `comment_field3` varchar(255) default NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('comment_field4', table_comments);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_comments . '` ADD `comment_field4` varchar(255) default NULL';
	$db->query($sql);
}
$fieldexists = checkforfield('comment_field5', table_comments);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_comments . '` ADD `comment_field5` varchar(255) default NULL';
	$db->query($sql);
}

//---------------------------------------------------------



//---------------------------------------------------------
//Added in Beta 7.0
//---------------------------------------------------------
	$sql = 'ALTER TABLE `' . table_comments . '` DROP INDEX `comments_randkey` , ADD UNIQUE KEY `comments_randkey` (`comment_randkey`,`comment_link_id`,`comment_user_id`,`comment_parent`)';
	$db->query($sql);
//---------------------------------------------------------


//---------------------------------------------------------
//Added in Beta 7.0 REV 47
//---------------------------------------------------------
$fieldexists = checkforfield('link_title_url', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_title_url` varchar(255) default NULL';
	$db->query($sql);
}
//---------------------------------------------------------

//---------------------------------------------------------
//
//---------------------------------------------------------
$fieldexists = checkforfield('link_summary', table_links);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` ADD `link_summary` varchar(255) default NULL';
	$db->query($sql);
}
//---------------------------------------------------------


//---------------------------------------------------------
//Added in Beta 7.1.0.7
//---------------------------------------------------------
$tableexists = checkfortable(table_prefix . 'pageviews');
if (!$tableexists) {
$sql = "CREATE TABLE `" . table_pageviews . "` (
  `pv_id` int(10) unsigned NOT NULL auto_increment,
  `pv_type` varchar(20) NOT NULL default '',
  `pv_page_id` int(11) NOT NULL default '0',
  `pv_datetime` timestamp NOT NULL,
  `pv_user_id` int(11) NOT NULL default '0',
  `pv_user_ip` varchar(64) default NULL,
  PRIMARY KEY (`pv_id`)
);";
	$db->query($sql);
}
//---------------------------------------------------------

//---------------------------------------------------------
$tableexists = checkfortable(table_prefix . 'config');
if (!$tableexists) {
	echo "Adding config table.<br>";
$sql = "CREATE TABLE `config` (
  `var_id` int(11) NOT NULL auto_increment,
  `var_page` varchar(50) NOT NULL,
  `var_name` varchar(100) NOT NULL,
  `var_value` varchar(50) NOT NULL,
  `var_defaultvalue` varchar(50) NOT NULL,
  `var_optiontext` varchar(200) NOT NULL,
  `var_title` varchar(200) NOT NULL,
  `var_desc` text NOT NULL,
  `var_method` varchar(10) NOT NULL,
  `var_enclosein` varchar(5) default NULL,
  PRIMARY KEY  (`var_id`)
);";
	$db->query($sql);
	
	$db_host = EZSQL_DB_HOST;	//---- Database host(usually localhost).
	$db_name = EZSQL_DB_NAME;	//---- Your database name.
	$db_user = EZSQL_DB_USER;	//---- Your database username.
	$db_pass = EZSQL_DB_PASSWORD;	//---- Your database password.
	include_once '../libs/backup/mysql_backup/mysql_backup.class.php';
	$output = "upgrade_config_table.sql"; // The data for the config table.
	$backup = new mysql_backup($db_host,$db_name,$db_user,$db_pass,$output,$structure_only);	
	$backup->restore(";");
}
//---------------------------------------------------------

$fieldexists = checkforfield('category_safe_name', table_categories);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `'.table_categories.'` ADD `category_safe_name`  varchar(64) default NULL ;';
	$db->query($sql);
	
	$cats = $db->get_col("Select category_name from " . table_categories . ";");
	if ($cats) {
		foreach($cats as $catname) {
			$db->query("UPDATE `" . table_categories . "` SET `category_name` = '".$catname."', `category_safe_name` = '".makeCategoryFriendly($catname)."' WHERE `category_name` ='".$catname."';");
		}
	}
}

	// Added SpellChecker #2
	$sql = "UPDATE `" . table_config . "` SET `var_defaultvalue` = '2', `var_optiontext` = '1 or 2 = on / 0 = off', `var_desc` = '1 = http://spellerpages.sourceforge.net/<br />2 = http://www.phpclasses.org/browse/package/2398.html (spell checker for people without aspell enabled in php.' WHERE `var_id` =57 LIMIT 1 ;";
	$db->query($sql);


	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'StorySummary_ContentTruncate';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (58, 'Summary', 'StorySummary_ContentTruncate', '150', '150', 'number', 'Content Truncate', 'When showing the story in summary mode (like on the main page), truncate the content to this many characters', 'define', NULL);");
	}

	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'SubmitSummary_Allow_Edit';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (59, 'Summary', 'SubmitSummary_Allow_Edit', '1', '1', 'number', 'Allow edit of Summary', 'Allow edit of Summary', 'define', NULL);");
	}

	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'Enable_User_Upload_Avatar';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (60, 'Avatars', 'Enable_User_Upload_Avatar', 'true', 'true', 'true / false', 'Allow user uploaded avatars', 'Allow user uploaded avatars', 'define', NULL);");
	}
	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'User_Upload_Avatar_Folder';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (61, 'Avatars', 'User_Upload_Avatar_Folder', '/avatars/user_uploaded', '/avatars/user_uploaded', 'path', 'Avatar storage page', 'This is the path relative to your pligg install. Ex: if you installed in a subfolder name pligg, you only put /avatars/user_uploaded and NOT /pligg/avatarsuser_uploaded', 'define', '" . '"' . "');");
	}
	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'Avatar_Large';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (62, 'Avatars', 'Avatar_Large', '30', '30', 'number', 'Large Avatar Size', 'Size of the large avatars', 'define', NULL);");
	}
	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'Avatar_Small';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (63, 'Avatars', 'Avatar_Small', '15', '15', 'number', 'Small Avatar Size', 'Size of the small avatars (like in comments)', 'define', NULL);");
	}
	
	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'use_title_as_link';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (64, 'Story', 'use_title_as_link', 'false', 'false', 'true / false', 'Use story title as link', 'Use the story title as link to storys website.', 'define', NULL);");
}
	
	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'open_in_new_window';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (65, 'Story', 'open_in_new_window', 'false', 'false', 'true / false', 'Open story title in new window', 'If use story title as link is true, this setting allows you to make the link open in a new window.', 'define', NULL);");
}

	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'use_thumbnails';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (66, 'Story', 'use_thumbnails', 'true', 'true', 'true / false', 'Thumbnails', 'Enable preview thumbnails when hovering over a story link.', 'define', NULL);");
}

	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'table_prefix';");
	if (mysql_num_rows($result) == 0) {
		// since we're upgrading, they probably don't have a prefix, so set it to '' (blank)
		$db->query("INSERT INTO `" . table_config . "` VALUES (67, 'MySQL', 'table_prefix', '', 'pligg_', 'text', 'Table Prefix', 'Table prefix. Ex: pligg_ makes the users table become pligg_users. Note: changing this will not automatically rename your tables!', 'define', ".'"\'"'.");");
}

	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'rating_to_publish';");
	if (mysql_num_rows($result) == 0) {
		// since we're upgrading, they probably don't have a prefix, so set it to '' (blank)
		$db->query("INSERT INTO `" . table_config . "` VALUES (68, 'Voting', 'rating_to_publish', '3', '3', 'number', 'Rating To Publish', 'For use with Voting Method 2.', 'define', NULL);");
	}
	
	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'enable_captcha';");
	if (mysql_num_rows($result) == 0) {
		// since we're upgrading, they probably don't have a prefix, so set it to '' (blank)
		$db->query("INSERT INTO `" . table_config . "` VALUES (69, 'Captcha', 'enable_captcha', 'true', 'true', 'true / false', 'User Registration Captcha', 'Enable or disable the user registration captcha.', 'define', NULL);");
	}
	
	$result = mysql_query("select * from `" . table_config . "` where `var_name` = 'enable_gzip_files';");
	if (mysql_num_rows($result) == 0) {
		// since we're upgrading, they probably don't have a prefix, so set it to '' (blank)
		$db->query("INSERT INTO `" . table_config . "` VALUES (70, 'Misc', 'enable_gzip_files', 'false', 'false', 'true / false', 'Enable Gzip File Compression', 'Enable or disable gzip compression on js files.', 'define', NULL);");
	}

	
$fieldexists = checkforfield('user_avatar_source', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_avatar_source` varchar(64) NOT NULL';
	$db->query($sql);
}


$fieldexists = checkforfield('user_location', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_location` varchar(255) default NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_occupation', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_occupation` varchar(255) default NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_lastip', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_lastip` varchar(20) default NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_lastlogin', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_lastlogin` timestamp NOT NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('user_ip', table_users);
if (!$fieldexists) {
	$sql = 'ALTER TABLE `' . table_users . '` ADD `user_ip` varchar(20) default NULL';
	$db->query($sql);
}

$fieldexists = checkforfield('link_summary', table_links);
if ($fieldexists) {
	$sql = 'ALTER TABLE `' . table_links . '` CHANGE `link_summary` `link_summary` text default NULL';
	$db->query($sql);
}


//---------------------------------------------------------
$tableexists = checkfortable(table_messages);
if (!$tableexists) {
	echo "Adding config table.<br>";
$sql = "CREATE TABLE `" .table_messages. "` (
  `idMsg` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `sender` int(11) NOT NULL default '0',
  `receiver` int(11) NOT NULL default '0',
  `senderLevel` int(11) NOT NULL default '0',
  `readed` int(11) NOT NULL default '0',
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`idMsg`)
);";
	$db->query($sql);
}
//---------------------------------------------------------


$fieldexists = checkforfield('rgt', table_categories);
if (!$fieldexists) {
	$sql = "ALTER TABLE `" . table_categories . "` ADD `rgt` int(11) NOT NULL";
	$db->query($sql);
}
$fieldexists = checkforfield('lft', table_categories);
if (!$fieldexists) {
	$sql = "ALTER TABLE `" . table_categories . "` ADD `lft` int(11) NOT NULL";
	$db->query($sql);
}
$fieldexists = checkforfield('category_enabled', table_categories);
if (!$fieldexists) {
	$sql = "ALTER TABLE `" . table_categories . "` ADD `category_enabled` int(11) NOT NULL default '1'";
	$db->query($sql);
}
$fieldexists = checkforfield('category_order', table_categories);
if (!$fieldexists) {
	$sql = "ALTER TABLE `" . table_categories . "` ADD `category_order` int(11) NOT NULL default '0'";
	$db->query($sql);
}
$fieldexists = checkforfield('category_color', table_categories);
if (!$fieldexists) {
	$sql = "ALTER TABLE `" . table_categories . "` ADD `category_color` varchar(6) default '000000'";
	$db->query($sql);
	
	$sql = "ALTER TABLE `" . table_categories . "` DROP INDEX `category_lang`";
	$db->query($sql);

	$sql = "ALTER TABLE `" . table_categories . "` ADD UNIQUE `key` (`category_name`)";
	$db->query($sql);
	
	$sql = "INSERT INTO `" . table_categories . "` VALUES (0, '" . $dblang . "', 0, 0, 'all', 'all', 0, 0, 2, 0, '000000');";
	$db->query($sql);

	$sql = "UPDATE `" . table_categories . "` SET `category__auto_id` = '0' WHERE `category_name` = 'all' LIMIT 1;";
	$db->query($sql);
}


include_once(mnminclude.'dbtree.php');
rebuild_the_tree();
ordernew();


// for the module system
$tableexists = checkfortable(table_modules);
if (!$tableexists) {
		$sql = "CREATE TABLE `" . table_modules . "` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` float NOT NULL,
  `folder` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE = MyISAM;";
		$db->query($sql);
	}

$result = mysql_query("select * from `" . table_modules . "` where `name` = 'Javascript Effects Pack';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_modules . "` VALUES (1, 'Javascript Effects Pack', 0.1, 'scriptaculous', 1);");
}

$result = mysql_query("select * from `" . table_modules . "` where `name` = 'Admin Modify Language';");
	if (mysql_num_rows($result) == 0) {
		$db->query("INSERT INTO `" . table_modules . "` VALUES (2, 'Admin Modify Language', 0.1, 'admin_language', 1);");
}

echo 'Clearing templates_c directory...<br />';

echo "<br /><b>If there were no errors displayed, upgrade is complete!</b>";

include(mnminclude.'admin_config.php');
$config = new pliggconfig;
$config->create_file("../settings.php");



include_once('../Smarty.class.php');
$smarty = new Smarty;
$smarty->config_dir= '';
$smarty->compile_dir = "../templates_c";
$smarty->template_dir = "../templates";
$smarty->config_dir = "..";
$smarty->clear_compiled_tpl();



//end of if post submit is Yes.
}
//end of no errors
}
else { 
	echo DisplayErrors($errors);
	echo '<p>Please fix the above error(s), upgrade halted!</p>';
}
$include='footer.php'; if (file_exists($include)) { include_once($include); }

?>