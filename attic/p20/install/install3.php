<?php
if (!$step) { header('Location: ./install.php'); die(); }

$file='../config.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! This is a fatal error."; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes! This is a fatal error."; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! Try renaming 'settings.php.default' to 'settings.php'"; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes!"; }
elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this file to 777 while editing."; }

if (!$errors) {
	$dbuser = $_POST['dbuser'];
	$dbpass = $_POST['dbpass'];
	$dbname = $_POST['dbname'];
	$dbhost = $_POST['dbhost'];

	if($conn = @mysql_connect($dbhost,$dbuser,$dbpass))
	 {
		$db_selected = mysql_select_db($dbname, $conn);
		if (!$db_selected) { die ('Error: '.$dbname.' : '.mysql_error()); }
		define('table_prefix', $_POST['tableprefix']);

		//these were taken out of the createtables function as they are required here.
		define('table_blogs', table_prefix . "blogs" );
		define('table_categories', table_prefix . "categories" );
		define('table_comments', table_prefix . "comments" );
		define('table_friends', table_prefix . "friends" );
		define('table_languages', table_prefix . "languages" );
		define('table_links', table_prefix . "links" );
		define('table_trackbacks', table_prefix . "trackbacks" );
		define('table_users', table_prefix . "users" );
		define('table_tags', table_prefix . "tags" );
		define('table_votes', table_prefix . "votes" );
		define('table_pageviews', table_prefix . "pageviews" );
		define('table_config', table_prefix . "config" );
		define('table_modules', table_prefix . "modules" );
		define('table_messages', table_prefix . "messages" );

		//time to create the tables
		echo '<p>Creating database tables...</p>';
		include_once ('../libs/db.php');
		include_once("installtables.php");
		if (pligg_createtables($conn) == 1) { echo "<p>Tables were created successfully!</p>"; }
		else { $errors[]="There was a problem creating the tables."; }
	}
	else { $errors[]="Could not connect to database."; }
}

if (!$errors) {
	// refresh / recreate settings
	// this is needed to update it with table_prefix if it has been changed from "pligg_"
	include_once( '../config.php' );
	include(mnminclude.'admin_config.php');
	$config = new pliggconfig;
	$config->create_file('../settings.php');

	$my_base_url = "http://" . $_SERVER["HTTP_HOST"];
	$my_pligg_base=dirname($_SERVER["PHP_SELF"]); $my_pligg_base=str_replace("/".substr(strrchr($my_pligg_base, '/'), 1),'',$my_pligg_base);

	$sql = "Update " . table_config . " set `var_value` = '" . $my_base_url . "' where `var_name` = '" . '$my_base_url' . "';";
	mysql_query( $sql, $conn );

	$sql = "Update " . table_config . " set `var_value` = '" . $my_pligg_base . "' where `var_name` = '" . '$my_pligg_base' . "';";
	mysql_query( $sql, $conn );

	$config = new pliggconfig;
	$config->create_file('../settings.php');

	//done
	$output='<p><a href="../">Pligg</a> appears to have installed successfully!</p>
	<p>Things to do next:</p>
	<ul>
	<li>chmod "../libs/dbconnect.php" back to 655, we will not need to change this file again.</li>
	<li>DELETE the "./install" directory from your server once you have successfully installed Pligg.</li>
	<li>Login to the <a href="../admin_config.php">admin area</a> (default username: god; default password: 12345)</li>
	<li>Change your password from the default password.</li>
	<li>Configure your installation using the admin area.</li>
	<li>Visit the <a href="http://www.pligg.com/forum/">Pligg Forums</a> if you have any questions.</li>
	</ul>';
}

if (isset($errors)) {
	$output=DisplayErrors($errors);
	$output.='<p>Please fix the above error(s), install halted!</p>';
}

if(function_exists("gd_info")) {}
else {
$config = new pliggconfig;
$config->var_id = 60;
$config->var_value = "false";
$config->store();
$config->var_id = 69;
$config->var_value = "false";
$config->store();
}

echo $output;

?>