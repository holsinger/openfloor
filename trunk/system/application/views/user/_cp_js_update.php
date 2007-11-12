<? if(!empty($current_question) && $this->userauth->isUser()): ?>
<script type="text/javascript" language="javascript">
	if(cpUpdater.current_question_id != <?=$current_question[0]['question_id']?>) cpUpdater.current_question_fade();
	cpUpdater.current_question_id = <?=$current_question[0]['question_id']?>;
	<? foreach($candidates as $v): ?>
	cpUpdater.sliders[<?=$v['can_id']?>].options.onChange = null;
	cpUpdater.sliders[<?=$v['can_id']?>].options.onSlide = null;
	cpUpdater.sliders[<?=$v['can_id']?>].setValue(<?=$v['user_reaction']/10?>);
	cpUpdater.sliders[<?=$v['can_id']?>].options.onChange =	
		function(v) {
			url = 'forums/react/' + Math.round(v*10) + '/' + <?=$v['can_id']?> + '/' + cpUpdater.current_question_id;
			new Ajax.Request(url, {
		 		onSuccess: function(transport) {
					cpUpdater.enableAJAX();
		  		}
			}); 
		};
	cpUpdater.sliders[<?=$v['can_id']?>].options.onSlide = 
		function(v) {
			cpUpdater.disableAJAX();
		};		
	cpUpdater.sliders[<?=$v['can_id']?>].setEnabled();
	<? endforeach; ?>
</script>
<? else: ?>
<? foreach($candidates as $v): ?>
<script type="text/javascript" language="javascript">
	cpUpdater.sliders[<?=$v['can_id']?>].setDisabled();
	cpUpdater.sliders[<?=$v['can_id']?>].options.onChange = null;
	cpUpdater.sliders[<?=$v['can_id']?>].options.onSlide = null;
	cpUpdater.sliders[<?=$v['can_id']?>].setValue(<?=$v['user_reaction']/10?>);
</script>
<? endforeach; ?>
<? endif; ?>