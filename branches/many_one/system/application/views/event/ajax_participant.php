<? if($respondent['status'] == 'responding'): ?>
	<? if($past_vote < 1): ?>
		<small>Let the respondent know that you don't feel that he/she is answering the question by clicking on the button below.</small><br /><br />
		<a href="javascript: <?= $this->userauth->isUser() ? 'var none = cpUpdater.ajaxParticipantVote(\'up\');' : 'window.location=\''.$this->config->item('m1_url').'/login/\';' ?>">
			<img src="images/ucp/not_answered_button.png" border="0" />
		</a>
	<? else: ?>
			<small>Let the respondent know that you don't feel that he/she is answering the question by clicking on the button below.</small><br /><br />
			<a href="javascript: <?= $this->userauth->isUser() ? 'var none = cpUpdater.ajaxParticipantVote(\'down\');' : 'window.location=\''.$this->config->item('m1_url').'/login/\';' ?>">
				<img src="images/ucp/answered_button.png" border="0" />
			</a>
	<? endif; ?>
<? else: ?>
	<small>
		Waiting for respondent to start....
	</small>
<? endif; ?>