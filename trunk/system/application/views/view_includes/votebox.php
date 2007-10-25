<?
#dependency queueUpdater.js
?>
<span id="xvote-<?= $question_id; ?>" class="next_invisible">
	<? if ($voted == 'up') { ?>
		<a class="voteup">voted</a>			
	<? } else { ?>
		<a href="javascript:queueUpdater.vote(site_url + '/question/voteup/<?= $event_url; ?>/question/<?= url_title($question_name); ?>','xnews-<?= $question_id; ?>');" class="up">up</a>
	<? } ?>	
</span>
<span id="xreport-<?= $question_id; ?>">
	<? if ($voted == 'down') { ?>
		<a class="votedown">voted</a>			
	<? } else { ?>
		<a href="javascript:queueUpdater.vote(site_url + '/question/votedown/<?= $event_url; ?>/question/<?= url_title($question_name); ?>','xnews-<?= $question_id; ?>');" class="down">down</a>
	<? } ?>
</span>