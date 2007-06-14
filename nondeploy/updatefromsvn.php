<?php
	echo "UpdateFromSVN.php v1.0<br>";
	echo "Running as: ";
	passthru("/usr/bin/whoami", $retval);
	echo "<br><br>";

	echo "Current directory: ";
	passthru("pwd", $retval);
	echo "<br><br>";

	echo "Initiating update from SVN ...<p>";

	passthru("/home/politic20/practice/admin/updatesite.sh", $retval);

	echo "<p> ... Update from SVN Completed!<p>";
	//phpinfo();
?>
