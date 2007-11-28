<? if(!$this->userauth->isUser()): ?>
	<img src ="./images/ucp/vote-up.jpg" alt="Vote Up" title="Vote Up" onclick="showBox('login')">
<? elseif ($voted > 0): ?>
	<div class='checkbox'></div>
<? else: ?>
	<img src="./images/ucp/vote-up.jpg" alt="Vote Up" title="Vote Up" onClick="javascript:cpUpdater.vote(site_url + 'question/voteup/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? endif; ?>

<? if(!$this->userauth->isUser()): ?>
	<img src ="./images/ucp/vote-down.jpg" alt="Vote Down" title="Vote Down" onclick="showBox('login')">
<? elseif ($voted < 0): ?>
	<div class='checkbox'></div>		
<? else: ?>
	<img src="./images/ucp/vote-down.jpg" alt="Vote Down" title="Vote Down" onClick="javascript:cpUpdater.vote(site_url + 'question/votedown/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? endif; ?>