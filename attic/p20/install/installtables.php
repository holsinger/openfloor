<?php
include_once ('../libs/db.php');

if (!isset($dblang)) { $dblang='en'; }

function pligg_createtables($conn) {

global $dblang;

$sql = 'DROP TABLE IF EXISTS `' . table_blogs . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_blogs . "` (
  `blog_id` int(20) NOT NULL auto_increment,
  `blog_key` varchar(35) default NULL,
  `blog_type` enum('normal','blog') NOT NULL default 'normal',
  `blog_rss` varchar(64) NOT NULL default '',
  `blog_rss2` varchar(64) NOT NULL default '',
  `blog_atom` varchar(64) NOT NULL default '',
  `blog_url` varchar(64) default NULL,
  PRIMARY KEY  (`blog_id`),
  UNIQUE KEY `key` (`blog_key`)
) TYPE = MyISAM;";
echo 'Creating table: \'blogs\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_categories . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_categories . "` (
  `category__auto_id` int(11) NOT NULL auto_increment,
  `category_lang` varchar(" . strlen($dblang) . ") NOT NULL default " . "'" . $dblang . "',
  `category_id` int(11) NOT NULL default '0',
  `category_parent` int(11) NOT NULL default '0',
  `category_name` varchar(64) NOT NULL default '',
  `category_safe_name` varchar(64) NOT NULL default '',
  `rgt` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `category_enabled` int(11) NOT NULL default '1',
  `category_order` int(11) NOT NULL default '0',
  `category_color` varchar(6) default '000000',
  PRIMARY KEY  (`category__auto_id`),
  UNIQUE KEY `key` (`category_name`)
) TYPE = MyISAM;";
echo 'Creating table: \'categories\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_comments . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_comments . "` (
  `comment_id` int(20) NOT NULL auto_increment,
  `comment_randkey` int(11) NOT NULL default '0',
  `comment_parent` int(20) default '0',
  `comment_link_id` int(20) NOT NULL default '0',
  `comment_user_id` int(20) NOT NULL default '0',
  `comment_date` timestamp NOT NULL,
  `comment_karma` smallint(6) NOT NULL default '0',
  `comment_nick` varchar(32) default NULL,
  `comment_content` text NOT NULL,
  `comment_votes` int(20) NOT NULL default '0',
  PRIMARY KEY  (`comment_id`),
  UNIQUE KEY `comments_randkey` (`comment_randkey`,`comment_link_id`,`comment_user_id`,`comment_parent`),
  KEY `comment_link_id_2` (`comment_link_id`,`comment_date`)
) TYPE = MyISAM;";
echo 'Creating table: \'comments\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_friends . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_friends . "` (
  `friend_id` int(11) NOT NULL auto_increment,
  `friend_from` bigint(20) NOT NULL default '0',
  `friend_to` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`friend_id`),
  UNIQUE KEY `friends_from_to` (`friend_from`,`friend_to`)
) TYPE = MyISAM;";
echo 'Creating table: \'friends\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_languages . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_languages . "` (
  `language_id` int(11) NOT NULL auto_increment,
  `language_name` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`language_id`),
  UNIQUE KEY `language_name` (`language_name`)
) TYPE = MyISAM;";
echo 'Creating table: \'languages\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_links . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_links . "` (
  `link_id` int(20) NOT NULL auto_increment,
  `link_author` int(20) NOT NULL default '0',
  `link_blog` int(20) default '0',
  `link_status` enum('discard','queued','published','abuse','duplicated') NOT NULL default 'discard',
  `link_randkey` int(20) NOT NULL default '0',
  `link_votes` int(20) NOT NULL default '0',
  `link_karma` decimal(10,2) NOT NULL default '0.00',
  `link_modified` timestamp NOT NULL,
  `link_date` timestamp NOT NULL,
  `link_published_date` timestamp NOT NULL,
  `link_category` int(11) NOT NULL default '0',
  `link_lang` int(11) NOT NULL default '1',
  `link_url` varchar(200) NOT NULL default '',
  `link_url_title` text,
  `link_title` text NOT NULL,
  `link_title_url` varchar(255) default NULL,
  `link_content` text NOT NULL,
  `link_summary` text default NULL,
  `link_tags` text,
  `link_field1` varchar(255) NOT NULL default '',
  `link_field2` varchar(255) NOT NULL default '',
  `link_field3` varchar(255) NOT NULL default '',
  `link_field4` varchar(255) NOT NULL default '',
  `link_field5` varchar(255) NOT NULL default '',
  `link_field6` varchar(255) NOT NULL default '',
  `link_field7` varchar(255) NOT NULL default '',
  `link_field8` varchar(255) NOT NULL default '',
  `link_field9` varchar(255) NOT NULL default '',
  `link_field10` text NOT NULL default '',
  `link_field11` text NOT NULL default '',
  `link_field12` text NOT NULL default '',
  `link_field13` text NOT NULL default '',
  `link_field14` text NOT NULL default '',
  `link_field15` text NOT NULL default '',
  PRIMARY KEY  (`link_id`),
  KEY `link_author` (`link_author`),
  KEY `link_url` (`link_url`),
  KEY `link_date` (`link_date`),
  KEY `link_published_date` (`link_published_date`),
  FULLTEXT KEY `link_url_2` (`link_url`,`link_url_title`,`link_title`,`link_content`,`link_tags`),
  FULLTEXT KEY `link_tags` (`link_tags`)
) TYPE = MyISAM;";
echo 'Creating table: \'links\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_trackbacks . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_trackbacks . "` (
  `trackback_id` int(10) unsigned NOT NULL auto_increment,
  `trackback_link_id` int(11) NOT NULL default '0',
  `trackback_user_id` int(11) NOT NULL default '0',
  `trackback_type` enum('in','out') NOT NULL default 'in',
  `trackback_status` enum('ok','pendent','error') NOT NULL default 'pendent',
  `trackback_modified` timestamp NOT NULL,
  `trackback_date` timestamp NULL default NULL,
  `trackback_url` varchar(200) NOT NULL default '',
  `trackback_title` text,
  `trackback_content` text,
  PRIMARY KEY  (`trackback_id`),
  UNIQUE KEY `trackback_link_id_2` (`trackback_link_id`,`trackback_type`,`trackback_url`),
  KEY `trackback_link_id` (`trackback_link_id`),
  KEY `trackback_url` (`trackback_url`),
  KEY `trackback_date` (`trackback_date`)
) TYPE = MyISAM;";
echo 'Creating table: \'trackbacks\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_users . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_users . "` (
  `user_id` int(20) NOT NULL auto_increment,
  `user_login` varchar(32) NOT NULL default '',
  `user_level` enum('normal','special','blogger','admin','god') NOT NULL default 'normal',
  `user_modification` timestamp NOT NULL,
  `user_date` timestamp NOT NULL,
  `user_pass` varchar(64) NOT NULL default '',
  `user_email` varchar(128) NOT NULL default '',
  `user_names` varchar(128) NOT NULL default '',
  `user_lang` int(11) NOT NULL default '1',
  `user_karma` decimal(10,2) default '10.00',
  `user_url` varchar(128) NOT NULL default '',
  `user_lastlogin` timestamp NOT NULL,
  `user_aim` varchar(64) NOT NULL default '',
  `user_msn` varchar(64) NOT NULL default '',
  `user_yahoo` varchar(64) NOT NULL default '',
  `user_gtalk` varchar(64) NOT NULL default '',
  `user_skype` varchar(64) NOT NULL default '',
  `user_irc` varchar(64) NOT NULL default '',
  `public_email` varchar(64) NOT NULL default '',
  `user_avatar_source` varchar(255) NOT NULL default '',
  `user_ip` varchar(20) default '0',
  `user_lastip` varchar(20) default '0',
  `last_reset_request` timestamp NOT NULL,
  `user_location` varchar(255) default NULL,
  `user_occupation` varchar(255) default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_login` (`user_login`),
  KEY `user_email` (`user_email`)
) TYPE = MyISAM;";
echo 'Creating table: \'users\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_tags . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_tags . "` (
  `tag_link_id` int(11) NOT NULL default '0',
  `tag_lang` varchar(4) NOT NULL default 'en',
  `tag_date` timestamp NOT NULL,
  `tag_words` varchar(64) NOT NULL default '',
  UNIQUE KEY `tag_link_id` (`tag_link_id`,`tag_lang`,`tag_words`),
  KEY `tag_lang` (`tag_lang`,`tag_date`)
) TYPE = MyISAM;";
echo 'Creating table: \'tags\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_votes . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_votes . "` (
  `vote_id` int(20) NOT NULL auto_increment,
  `vote_type` enum('links','comments') NOT NULL default 'links',
  `vote_date` timestamp NOT NULL,
  `vote_link_id` int(20) NOT NULL default '0',
  `vote_user_id` int(20) NOT NULL default '0',
  `vote_value` smallint(11) NOT NULL default '1',
  `vote_ip` varchar(64) default NULL,
  PRIMARY KEY  (`vote_id`),
  KEY `user_id` (`vote_user_id`),
  KEY `link_id` (`vote_link_id`),
  KEY `vote_type` (`vote_type`,`vote_link_id`,`vote_user_id`,`vote_ip`)
) TYPE = MyISAM;";
echo 'Creating table: \'votes\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_pageviews . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_pageviews . "` (
  `pv_id` int(10) unsigned NOT NULL auto_increment,
  `pv_type` varchar(20) NOT NULL default '',
  `pv_page_id` int(11) NOT NULL default '0',
  `pv_datetime` timestamp NOT NULL,
  `pv_user_id` int(11) NOT NULL default '0',
  `pv_user_ip` varchar(64) default NULL,
  PRIMARY KEY (`pv_id`)
) TYPE = MyISAM;";
echo 'Creating table: \'pageviews\'....<BR/>';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_config . '`;';
mysql_query( $sql, $conn );

echo "Creating table: 'config'<br>";
$sql = "CREATE TABLE `" . table_config . "` (
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
) TYPE = MyISAM;";
echo 'Creating table: \'config\'....<BR/>';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_messages . '`;';
mysql_query( $sql, $conn );

echo "Creating table: 'messages'<br>";
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
) TYPE = MyISAM;";
echo 'Creating table: \'messages\'....<BR/>';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_modules . '`;';
mysql_query( $sql, $conn );

echo "Creating table: 'modules'<br>";
$sql = "CREATE TABLE `" . table_modules . "` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` float NOT NULL,
  `folder` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE = MyISAM;";
echo 'Creating table: \'modules\'....<BR/>';
mysql_query( $sql, $conn );



echo "Creating 'god' user...<br />";
$sql = "INSERT INTO `" . table_users . "` VALUES (1, 'god', 'god', now(), now(), '1e41c3f5a260b83dd316809b221f581cdbba8c1489e6d5896', 'blank@pligg.com', '', 1, 10.00, 'www.pligg.com', now(), '', '', '', '', '', '', '', '', '0', '0', now(), '', '');";
mysql_query( $sql, $conn );

echo 'Inserting default categories...<br />';
$sql = "INSERT INTO `" . table_categories . "` VALUES (0, '" . $dblang . "', 0, 0, 'all', 'all', 0, 0, 2, 0, '000000');";
mysql_query( $sql, $conn );

$sql = "UPDATE `" . table_categories . "` SET `category__auto_id` = '0' WHERE `category_name` = 'all' LIMIT 1;";
mysql_query( $sql, $conn );

$sql = "INSERT INTO `" . table_categories . "` VALUES (1, '" . $dblang . "', 1, 0, 'pligg', 'pligg', 0, 0, 1, 0, '000000');";
mysql_query( $sql, $conn );

echo 'Inserting default modules...<br />';
$sql = "INSERT INTO `" . table_modules . "` VALUES (1, 'Javascript Effects Pack', 0.1, 'scriptaculous', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` VALUES (2, 'Admin Modify Language', 0.1, 'admin_language', 1);";
mysql_query( $sql, $conn );


echo "Inserting default 'config' data...<br />";

$fs = fopen( 'upgrade_config_table.sql', 'r' );

while( ! feof( $fs ) )
{
    $tmp = fgets( $fs );
    $tmp = str_replace("INSERT INTO `config`", "INSERT INTO `".table_config."`", $tmp);
    $tmp = str_replace("'table_prefix', 'pligg_'", "'table_prefix', '" . table_prefix . "'", $tmp);
    
    mysql_query( $tmp );
}

fclose( $fs );

return 1;
}

?>