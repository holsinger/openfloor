<?php

?>
<!-- right column start here -->
</td>
<td class="col-right" valign="top">
	
	<?
	//build the data array
	//exit (var_dump($rightpods));
	foreach ($rightpods as $title => $val) {
		$this->load->view('view_includes/view_right_'.$title.'.php',$rightpods);
	}
	?>
</td>