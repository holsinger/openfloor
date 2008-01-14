<!-- 181px on slider is 100% -->
<div id="track<?=$user_id?>" class="track" style="width:150px; height:9px;">
	<div id="track<?=$user_id?>-left" class="track-left"></div>
	<div id="handle<?=$user_id?>" <?= $this->userauth->isUser() ? '' : 'onclick="showBox(\'login\')"' ?> style="width:19px; height:20px;">
		<div id="handle-img-<?=$user_id?>" class="reaction_handle"></div>
	</div>
</div>
<script type="text/javascript" language="javascript">
// <![CDATA[

	cpUpdater.current_question_id = <?= empty($current_question) ? 0 : $current_question[0]['question_id'] ?>;

	// horizontal slider control
	slider = new Control.Slider('handle<?=$user_id?>', 'track<?=$user_id?>', {
		sliderValue: <?=$user_reaction/10?>,
		onChange: function(v) {
			url = 'forums/react/' + Math.round(v*10) + '/' + <?=$user_id?> + '/' + cpUpdater.current_question_id;
			new Ajax.Request(url, {
		 		onSuccess: function(transport) {
					cpUpdater.enableAJAX();
		  		}
			}); 
		},
		onSlide: function(v) {
			cpUpdater.disableAJAX();
		}
	});
	
	cpUpdater.sliders[<?=$user_id?>] = slider;
	
// ]]>
</script>
