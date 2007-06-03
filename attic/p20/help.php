Pligg WTF v0.1.1
<hr />
<?php

include('config.php');

echo "my_base_url = " . my_base_url . "<br />";
echo "my_pligg_base = " . my_pligg_base . "<hr />";

$file='libs/dbconnect.php';
if (!file_exists($file)) { echo $file.' was not found! You should re-install.'; }
elseif (filesize($file) <= 0) { echo $file.' is 0 bytes! You should re-install.'; }

$file='settings.php';
if (!file_exists($file)) { echo $file.' was not found! Try renaming settings.php.default to settings.php'; }
elseif (filesize($file) <= 0) { echo $file.' is 0 bytes!'; }
elseif (!is_writable($file)) { echo $file.' is not writable! Please chmod this file to 777 while editing.'; }

$file='config.php';
if (!file_exists($file)) { echo $file.' was not found! This is a fatal error.'; }
elseif (filesize($file) <= 0) { echo $file.' is 0 bytes! This is a fatal error.'; }

if (!function_exists('imagecreatefromjpeg')) {
	echo '<b><font color="red">Problem:</font></b> GD is not installed. <br />';
	echo 'Solution: Please view "Installation" section <a href = "http://php.net/ref.image" target="_blank">here</a>.<hr />';
}

if ($URLMethod == 2 && !file_exists('./pligg/.htaccess')){
	echo '<b><font color="red">Problem:</font></b> You have URLMethod set to "2" but ".htaccess" does not exist!<br />';
	echo "Solution: Rename .htaccess.default to .htaccess<HR />";
}

if($my_base_url == ''){
	echo '<b><font color="red">Problem:</font></b> my_base_url is not set.<br />';
	echo 'Solution: Please correct this using the <a href = "admin_config.php?page=Location%20Installed">admin panel</a><hr />';
}

$canContinue = DoesExist ( $canContinue, './templates_c', 0777, 'templates_c' );
$canContinue = DoesExist ( $canContinue, './cache', 0777, 'cache' );

$canContinue = isWriteable ( $canContinue, './libs/dbconnect.php', 0777, '/libs/dbconnect.php' );
$canContinue = DoesExist ( $canContinue, './libs/options.php', 0777, '/libs/options.php' );


function DoesExist ( $canContinue, $file, $mode, $desc )
{
	@chmod( $file, $mode );
	$good = file_exists( $file ) ? 1 : 0;
	Message ( $desc.' exists?: ', $good );
	return ( $canContinue && $good );
}

function isWriteable ( $canContinue, $file, $mode, $desc )
{
	@chmod( $file, $mode );
	$good = is_writable( $file ) ? 1 : 0;
	Message ( $desc.' is writable: ', $good );
	return ( $canContinue && $good );
}
function Message( $message, $good )
{
	if (!$good){
		$yesno = '<b><font color="red">No</font></b>';
		echo $message .' '. $yesno .'<hr />';
	}
}

?>

If there are no errors then yay! If there are errors, fix them.