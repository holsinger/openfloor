<img class="img-flag" src="./images/flag.png" onclick="javascript:queueUpdater.toggleQueue();new Effect.toggle('flag_question<?=$question_id?>','blind', {queue: 'end'});"/>
<div id="flag_question<?=$question_id?>" class="flag" style="display:none;">
	<span class="flag-option"><a>Inappropriate</a></span>	
	<span class="flag-option"><a>Duplicate</a></span>	
</div>