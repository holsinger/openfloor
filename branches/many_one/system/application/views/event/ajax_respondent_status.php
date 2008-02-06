<? if($respondent['current_responder']): ?>
	<? if($respondent['status'] == 'responding'): ?>
		<div>
			The bar graph below represents whether or not the participants in this event feel you have answered the current question.  A full bar means that participants feel you are answering the question.
		</div>	
		<div style=" padding-top: 15px; padding-bottom: 20px; padding-left: 90px;">
			<div style="float: left; color: #F04A54; lineheight: 25px; vertical-alignment: middle; padding: 5px;">Not Answered</div>
			<div class="overall-reaction-meter-respondent" id="respondent_unanswered_total" style="float: left;width: 150px;">
				<?
				if ($unanswered_percent >= 75) {
					$bar_class = "overall-reaction-meter-green";
				}elseif($unanswered_percent >= 50){
					$bar_class = "overall-reaction-meter-yellow";
				}else{
					$bar_class="overall-reaction-meter";
				}
				?>
				<div class="<?=$bar_class?>" id="respondent_unanswered_meter" style="width: <?=$unanswered_percent?>%; height: 15px"></div>
			</div>
			<div style="float: left; color: #62eb62; lineheight: 25px; vertical-alignment: middle; padding: 5px;">Answered</div>
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