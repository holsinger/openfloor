<? if(!$this->userauth->isUser()): ?>
	<img src ="./images/<?=$this->config->item('custom_theme');?>/thumbsUp.png" alt="Vote Up" class="link" title="Vote Up" onclick="showBox('login')">
<? elseif ($voted > 0): ?>
	<img src="./images/<?=$this->config->item('custom_theme');?>/votedCheckBoxBG.png"/>
<? else: ?>
	<img src="./images/<?=$this->config->item('custom_theme');?>/thumbsUp.png" alt="Vote Up" class="link" title="Vote Up" onClick="javascript:cpUpdater.vote(site_url + 'question/voteup/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? endif; ?>

<? if(!$this->userauth->isUser()): ?>
	<img src ="./images/<?=$this->config->item('custom_theme');?>/thumbsDown.png" alt="Vote Down" class="link" title="Vote Down" onclick="showBox('login')">
<? elseif ($voted < 0): ?>
	<img src="./images/<?=$this->config->item('custom_theme');?>/votedCheckBoxBG.png"/>		
<? else: ?>
	<img src="./images/<?=$this->config->item('custom_theme');?>/thumbsDown.png" alt="Vote Down" class="link" title="Vote Down" onClick="javascript:cpUpdater.vote(site_url + 'question/votedown/event/<?= $event_url_name; ?>/question/<?= url_title($question_name); ?>');"/>
<? endif; ?>