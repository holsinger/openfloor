<?php
foreach ($dynamic as $key => $data) {
?>
<div class="post">
	<div class="double_line_container">
		<h1><?=ucwords(str_replace("_"," ",$key));?></h1>
	</div>
	<br />
	<div class="box">
		<?=$data;?>
	</div>
	<br />
</div> 
<? } ?>