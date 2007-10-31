<?php
foreach ($dynamic as $key => $data) {
?>
<div class="post">
<h1><?=ucwords(str_replace("_"," ",$key));?></h1>
<br />
<div class="box">
<?=$data;?>
</div>
<br />
</div> 
<? } ?>