<?php

$include='header.php'; if (file_exists($include)) { include_once($include); }
$include='functions.php'; if (file_exists($include)) { require_once($include); }

if (isset($_POST['step'])) { $step=$_POST['step']; }

//check for no steps, start on step1
if ((!isset($step)) || ($step == "")) { $step=1; }

echo '<h3>Step '.$step.': </h3>';

//step1, error checking and enter database settings
if ($step == 1) { include('install1.php'); }

//step2, check database settings, store to file
if ($step == 2) { include('install2.php'); }

//step3, update config settings file, 
if ($step == 3) { include('install3.php'); }

$include='footer.php'; if (file_exists($include)) { include_once($include); }

?>