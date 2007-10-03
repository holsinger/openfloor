<? if(!empty($current_question)): ?>
<script type="text/javascript" language="javascript">
	cpUpdater.current_question_id = <?=$current_question[0]['question_id']?>;
	<? foreach($candidates as $v): ?>
	cpUpdater.sliders[<?=$v['can_id']?>].options.onChange = null;
	cpUpdater.sliders[<?=$v['can_id']?>].options.onSlide = null;
	cpUpdater.sliders[<?=$v['can_id']?>].setValue(<?=$v['user_reaction']/10?>);
	cpUpdater.sliders[<?=$v['can_id']?>].options.onChange =	
		function(v) {
			url = 'conventionnext/react/' + Math.round(v*10) + '/' + <?=$v['can_id']?> + '/' + cpUpdater.current_question_id;
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
	<?php endforeach; ?>
</script>
<? endif; ?>