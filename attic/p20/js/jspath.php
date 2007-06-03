<?php
// this is so .js file will have access to some of the pligg variables
include_once('../config.php');
header("content-type: application/x-javascript");
?>
var my_base_url='<?php echo my_base_url ?>';
var my_pligg_base='<?php echo my_pligg_base ?>';