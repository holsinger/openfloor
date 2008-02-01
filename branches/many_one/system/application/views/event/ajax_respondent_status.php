<? if($respondent['current_responder']): ?>
	<? if($respondent['status'] == 'responding'): ?>
		<div>
			The bar graph below represents whether or not the participants in this event feel you have answered the current question.  A full bar means that participants feel you are answering the question.
		</div>	
		<div style=" padding-top: 15px; padding-bottom: 20px;">
			<div style="float: left; color: #F04A54; lineheight: 25px; vertical-alignment: middle; padding: 5px;">Not Answered</div>
			<div class="overall-reaction-meter-total" id="respondent_unanswered_total" style="float: left;width: 150px;">
				<div class="overall-reaction-meter" id="respondent_unanswered_meter" style="width: <?=$unanswered_percent?>; height: 15px"></div>
			</div>
			<div style="float: left; color: #F04A54; lineheight: 25px; vertical-alignment: middle; padding: 5px;">Answered</div>
		</div>
		<div style="height: 20px;"></div>
		<small>You are currently responding.  When you finish your response click on the button below.</small>
		<a href="javascript:var none = cpUpdater.ajaxRespondentAction('finish');">
			<img src="images/ucp/finish_response_button.png" border="0" />
		</a>
	<? else: ?>
		<small>It is your turn to respond!  When you are ready click on the button below.</small>
		<a href="javascript:var none = cpUpdater.ajaxRespondentAction('start');">
			<img src="images/ucp/start_response.png" border="0" />
		</a>
	<? endif; ?>
<? else: ?>
	Another Respondent is answering the question.
<? endif; ?>