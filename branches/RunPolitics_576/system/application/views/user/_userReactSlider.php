<? if($user_reaction > 0): ?>
<a href="<?=site_url("conventionnext/react/-1/$can_id/{$current_question[0]['question_id']}/")?>">
<!-- <a href="javascript:cpUpdater.react(site_url + '/conventionnext/react/-1/<?=$can_id?>/<?=$current_question[0]['question_id']?>');"> -->
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

<!-- <a href="javascript:queueUpdater.vote(site_url + '/question/votedown/<?= $event_url; ?>/question/<?= url_title($question_name); ?>','xnews-<?= $question_id; ?>');" class="down">down</a> -->
