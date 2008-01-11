<? if(!$this->userauth->isUser()): ?>
	<img src ="./images/many_one/thumbsUp.png" alt="Vote Up" title="Vote Up" onclick="showBox('login')">
<? elseif ($voted > 0): ?>
	<img src="./images/votedCheckBoxBG.png"/>
<? else: ?>
	<img src="./images/many_one/thumbsUp.png" alt="Vote Up" title="Vote Up" onClick="javascript:cpUpdater.vote(site_url + 'question/voteup/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? endif; ?>

<? if(!$this->userauth->isUser()): ?>
	<img src ="./images/many_one/thumbsDown.png" alt="Vote Down" title="Vote Down" onclick="showBox('login')">
<? elseif ($voted < 0): ?>
	<img src="./images/votedCheckBoxBG.png"/>		
<? else: ?>
	<img src="./images/many_one/thumbsDown.png" alt="Vote Down" title="Vote Down" onClick="javascript:cpUpdater.vote(site_url + 'question/votedown/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? endif; ?>