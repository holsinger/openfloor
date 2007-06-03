<?php
$include='header.php'; if (file_exists($include)) { include_once($include); }
$include='functions.php'; if (file_exists($include)) { require_once($include); }

echo '<h3>Troubleshooter:</h3>';

$file='../libs/dbconnect.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! You should re-install."; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes! You should re-install."; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! Try renaming 'settings.php.default' to 'settings.php'"; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes!"; }
elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this file to 777 while editing."; }

$file='../config.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! This is a fatal error."; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes! This is a fatal error."; }

if (!$errors) {
	include_once('../config.php');
	
	$output .='<ul>';
	if (!function_exists('imagecreatefromjpeg')) { $output .= '<li>GD is not installed - Visit: <a href = "http://php.net/ref.image#image.installation">PHP Image Installation</a></li>'; }
	if ($URLMethod == 2 && !file_exists('../.htaccess')) { $output .= '<li>URL Method 2 is not working - .htaccess does not exist rename "htaccess.default" to ".htaccess"</li>'; }
	if ((!$my_base_url) || ($my_base_url == '')) { $output .= '<li>Base URL is not set - Visit: <a href = "admin_config.php?page=Location%20Installed">Admin Config - Location Installed</a></li>'; }
	if (!is_writable('../templates_c')) { $output .= '<li>"template_c" directory is not writable - issue: chmod 0777 template_c</li>'; }
	if (!is_writable('../cache')) { $output .= '<li>"cache" directory is not writable - issue: chmod 0777 cache</li>'; }
	if (!check_lang_conf("0.8")) { $output .= '<li>Your lang.conf is not latest - please check your current lang.conf against the latest version for any changes.</li>'; }
	$output .= '</ul>';
      $output .= '<p><b>No errors were found.</b></p>';
	$output .= '<p>Still need more help? Try the <a href="http://www.pligg.com/forum/">Pligg Forum</a></p>';
}
else {
	$output=DisplayErrors($errors);
	$output.='<p>Please fix the above error(s).</p>';
}

echo $output;

$include='footer.php'; if (file_exists($include)) { include_once($include); }
?>