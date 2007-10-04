<? if ($voted > 0) { ?>
	<img src="./images/votedCheckBox.png"/>
<? } else { ?>
	<img src="./images/ucp/vote-up.jpg" onClick="javascript:cpUpdater.vote(site_url + 'question/voteup/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? } ?>

<? if ($voted < 0) { ?>
	<img src="./images/votedCheckBox.png"/>		
<? } else { ?>
	<img src="./images/ucp/vote-down.jpg" onClick="javascript:cpUpdater.vote(site_url + 'question/votedown/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? } ?>