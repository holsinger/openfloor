<?php

?>
<!-- right column start here -->
<div id="right">

<?
//build the data array

foreach ($rightpods as $title => $val) {
	$this->load->view('view_includes/view_right_'.$title.'.php',$rightpods);
}
?>

</div>