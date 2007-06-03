<?php
if (!$step) { header('Location: ./install.php'); die(); }

$file='../config.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! This is a fatal error."; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes! This is a fatal error."; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! Try renaming 'settings.php.default' to 'settings.php'"; }
elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes!"; }
elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this file to 777 while editing."; }

$file='../libs/dbconnect.php';
if (!file_exists($file)) { $errors[]="'$file' was not found! Try renaming 'dbconnect.php.default' to 'dbconnect.php' or create a new one."; }
elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this file to 777 during installation."; }

$file='../templates_c';
if (!file_exists($file)) { $errors[]="'$file' was not found! Create a directory called templates_c in your root directory."; }
elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this file to 777 during installation."; }

$file='../cache';
if (!file_exists($file)) { $errors[]="'$file' was not found! Create a directory called templates_c in your root directory."; }
elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this file to 777 during installation."; }

if (!$errors) {

$output='<p>Enter your MySQL database settings below:</p>
<table>
<form id="form1" name="form1" method="post">
<tr>
<td><label>Database Name</label></td>
<td><input name="dbname" type="text" value="" /></td>
</tr>

<tr>
<td><label>Database Username</label></td>
<td><input name="dbuser" type="text" value="" /></td>
</tr>

<tr>
<td><label>Database Password</label></td>
<td><input name="dbpass" type="password" value="" /></td>
</tr>
  
<tr>
<td><label>Database Server</label></td>
<td><input name="dbhost" type="text" value="localhost" /></td>
</tr>

<tr>
<td><label>Table Prefix</label></td>
<td><input name="tableprefix" type="text" value="pligg_" />
</tr>

<tr>
<td colspan=2>(ie: "pligg_" makes the tables for users become pligg_users)</td>
</tr>

<tr>
<td><label></label></td>
<td><input type="submit" name="Submit" value="Check Settings" /></td>
</tr>
<input type="hidden" name="step" value="2">
</form>
</table>';

}
else { 
	$output=DisplayErrors($errors);
	$output.='<p>Please fix the above error(s), install halted!</p>';
}

echo $output;

?>