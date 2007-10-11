<!-- 181px on slider is 100% -->
<div id="track<?=$can_id?>" class="track" style="width:150px; height:9px;">
	<div id="track<?=$can_id?>-left" class="track-left">
	</div>
	<div id="handle<?=$can_id?>" style="width:19px; height:20px;"><img id="handle-img-<?=$can_id?>" src="./images/slider-images-handle.png" alt="" style="float: left;" />
	</div>
</div>
<script type="text/javascript" language="javascript">
// <![CDATA[

	cpUpdater.current_question_id = <?= empty($current_question) ? 0 : $current_question[0]['question_id'] ?>;

	// horizontal slider control
	slider = new Control.Slider('handle<?=$can_id?>', 'track<?=$can_id?>', {
		sliderValue: <?=$user_reaction/10?>,
		onChange: function(v) {
			url = 'forums/react/' + Math.round(v*10) + '/' + <?=$can_id?> + '/' + cpUpdater.current_question_id;
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
	
	cpUpdater.sliders[<?=$can_id?>] = slider;
	
// ]]>
</script>
