<?php
if (!$step) { header('Location: ./install.php'); die(); }

$file='../libs/dbconnect.php';

$dbuser = $_POST['dbuser'];
$dbpass = $_POST['dbpass'];
$dbname = $_POST['dbname'];
$dbhost = $_POST['dbhost'];

if($conn = @mysql_connect($dbhost,$dbuser,$dbpass)) {
	echo "<p>Database connection established...</p>\n";
	if(mysql_select_db($dbname, $conn)) {
	echo "<p>Found database...</p>\n";
		if($handle = fopen($file, 'w')) {
			$str  = "<?php\n";
			$str .= 'define("EZSQL_DB_USER", "'.$_POST['dbuser'].'");'."\n";
			$str .= 'define("EZSQL_DB_PASSWORD", "'.$_POST['dbpass'].'");'."\n";
			$str .= 'define("EZSQL_DB_NAME", "'.$_POST['dbname'].'");'."\n";
			$str .= 'define("EZSQL_DB_HOST", "'.$_POST['dbhost'].'");'."\n";
			$str .= "if (!function_exists('gettext')) {"."\n";
			$str .= '	function _($s) {return $s;}'."\n";
			$str .= '}'."\n";
			$str .= "?>";

			if(fwrite($handle, $str)) {
				echo "<p>'$file' was updated successfully.</p>\n";
				fclose($handle);
			} 
			else { $errors[]="Could not write to '$file' file."; }
		} 
		else { $errors[]="<b>Could not open '$file' file for writing."; }
	}
	else { $errors[]='Connected to the database, but the database name is incorrect.'; }
}
else { $errors[]='Cannot connect to the database <b>server</b> using the information provided.'; }

if (!$errors) {
	$output.='<p>There were no errors, continue onto the next step...</p>
	<form id="form2" name="form2" method="post">
	  <input type="hidden" name="dbuser" value="'.$_POST['dbuser'].'" />
	  <input type="hidden" name="dbpass" value="'.$_POST['dbpass'].'" />
	  <input type="hidden" name="dbname" value="'.$_POST['dbname'].'" />
	  <input type="hidden" name="dbhost" value="'.$_POST['dbhost'].'" />
	  <input type="hidden" name="tableprefix" value="'.$_POST['tableprefix'].'" />
	  <input type="hidden" name="step" value="3">
	  <input type="submit" name="Submit" value="Next" />
	  </form>';
}
else {
  $output=DisplayErrors($errors);
  $output.='<form id="thisform">
  <input type=button onclick="window.history.go(-1)" value="Go Back" />
  </form>';
}
echo $output;
?>