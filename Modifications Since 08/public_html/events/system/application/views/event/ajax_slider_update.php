<?=header('Content-type: application/javascript');?>
<? for($i = 0; $i < count($respondents); $i++): ?>
	// Because setValue will fire the events, we want to null them out before using it
	cpUpdater.sliders[<?=$respondents[$i]['user_id']?>].options.onChange = null;
	cpUpdater.sliders[<?=$respondents[$i]['user_id']?>].options.onSlide = null;
	
	cpUpdater.sliders[<?=$respondents[$i]['user_id']?>].setValue(<?=($respondents[$i]['slider_value'] == -1)?(5):($respondents[$i]['slider_value'])?>);
	<? if($respondents[$i]['slider_value'] == -1): ?>
			$('handle-img-<?=$respondents[$i]['user_id']?>').removeClassName('reaction_handle_voted');
			$('handle-img-<?=$respondents[$i]['user_id']?>').addClassName('reaction_handle');
	<? else: ?>
			$('handle-img-<?=$respondents[$i]['user_id']?>').addClassName('reaction_handle_voted');
	<? endif; ?>
	
	// Reset the events with the new question id
	cpUpdater.sliders[<?=$respondents[$i]['user_id']?>].options.onChange = function(v) {
		new Ajax.Request('forums/react/' + v + '/<?=$respondents[$i]['user_id']?>/<?=$new_question_id?>', {
	 		onSuccess: function(transport) {
				cpUpdater.enableAJAX();
				$('handle-img-<?=$respondents[$i]['user_id']?>').innerHTML = '';
				$('handle-img-<?=$respondents[$i]['user_id']?>').removeClassName('reaction_handle_slide');
				$('handle-img-<?=$respondents[$i]['user_id']?>').addClassName('reaction_handle_voted');
	  		}
		});
	 
	}
	cpUpdater.sliders[<?=$respondents[$i]['user_id']?>].options.onSlide = function(v) {
		cpUpdater.disableAJAX();
		$('handle-img-<?=$respondents[$i]['user_id']?>').addClassName('reaction_handle_slide');
		$('handle-img-<?=$respondents[$i]['user_id']?>').innerHTML = v;
	}
<? endfor; ?>