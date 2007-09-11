<? if($user_reaction > 0): ?>
<a href="<?=site_url("conventionnext/react/-1/$can_id/{$current_question[0]['question_id']}/")?>">
	<img src="./images/vote_thumbsDown.png"/>
</a>
<? else: ?>
	<img src="./images/vote_blank.png"/>
<? endif; ?>
<img src="./images/reaction<?=$user_reaction?>.png"/>
<? if($user_reaction < 5): ?>
<a href="<?=site_url("conventionnext/react/1/$can_id/{$current_question[0]['question_id']}/")?>">
	<img src="./images/vote_thumbsUp.png"/>
</a>
<? else: ?>
	<img src="./images/vote_blank.png"/>
<? endif; ?>