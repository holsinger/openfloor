<?php
foreach ($dynamic as $key => $data) {
?>
<div class="post">
<h1><?=str_replace("_"," ",strtoupper($key));?></h1>
<br />
<div class="box">
<?=$data;?>
</div>
<br />
</div> 
<? } ?>