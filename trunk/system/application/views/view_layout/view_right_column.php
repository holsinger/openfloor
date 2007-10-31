<?php

?>
<!-- right column start here -->
<div class="col-right" id="col_right">

<?
//build the data array
//exit (var_dump($rightpods));
foreach ($rightpods as $title => $val) {
	$this->load->view('view_includes/view_right_'.$title.'.php',$rightpods);
}
?>

</div>