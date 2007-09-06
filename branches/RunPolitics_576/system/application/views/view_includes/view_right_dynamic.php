<?php
foreach ($dynamic as $key => $data) {
?>
<h3><a class="close" onclick="new Effect.toggle('<?=$key;?>','blind', {queue: 'end'}); ">close</a><span><?=ucwords(str_replace('_',' ',$key));?></span></h3>
<div class="box">
<div class="inner-box" id="<?=$key;?>">
 <span style="padding-left:5px;"><?=$data;?></span>
</div>
</div>
<div class="box-bottom"></div> 
<? } ?>