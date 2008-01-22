<table>
	<tr>
		<th class="sp_arrow"></th>
		<th class="candidate">&nbsp;&nbsp;Speaker</th>
		<th style="background-color:#3561b7;">Your Reaction</th>
		<th class="reaction">Overall&nbsp;&nbsp;</th>
	</tr>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
		<tr<?=$class?>>
			<td class="sp_arrow"><img src="./images/ucp/speaker_arrow.png" border="0" /></td>
			<td><?= $v['avatar'] . '&nbsp;' . $v['link_to_profile'] ?></td>
			<td><div id="your-reaction-<?=$v['user_id']?>">
					<div id="track<?=$v['user_id']?>" class="track" style="width:150; height:9px;">
						<!-- <div id="track<?=$v['user_id']?>-left" class="track-left"></div> -->
						<div id="handle<?=$v['user_id']?>" <?= $this->userauth->isUser() ? '' : 'onclick="showBox(\'login\')"' ?> style="width:19px; height:20px;">
							<div id="handle-img-<?=$v['user_id']?>" class="<?=($v['user_reaction'] == -1)?"reaction_handle":"reaction_handle_voted"?>"></div>
						</div>
					</div>
				</div>
			</td>
			<td>
				<div id="overall-reaction-<?=$v['user_id']?>">
					<div class="overall-reaction-meter-total" id="overall-reaction-meter-total-<?=$v['user_id']?>">
						<div class="overall-reaction-meter" id="overall-reaction-meter-<?=$v['user_id']?>" style="width: 0%; height: 15px"></div>
					</div>
				</div>
			</td>
		</tr>
		<? $class = $class ? '' : ' class="alternate"' ?>
		<script type="text/javascript" language="javascript">
		// <![CDATA[

			cpUpdater.current_question_id = <?= empty($current_question) ? 0 : $current_question[0]['question_id'] ?>;

			// horizontal slider control
			slider = new Control.Slider('handle<?=$v['user_id']?>', 'track<?=$v['user_id']?>', {
				sliderValue: <?=($user_reaction == -1)?(5/10):($v['user_reaction']/10)?>,
				onChange: function(v) {
					// v = parseFloat(v);
					// 					var remainder = v % .1;
					// 					if(remainder){						
					// 						cpUpdater.sliders[<?=$v['user_id']?>].setValue(v.toFixed(1));
					// 						console.log(v.toFixed(1));
						new Ajax.Request('forums/react/' + Math.round(v*10) + '/' + <?=$v['user_id']?> + '/' + cpUpdater.current_question_id, {
					 		onSuccess: function(transport) {
								cpUpdater.enableAJAX();
								$('handle-img-<?=$v["user_id"]?>').addClassName('reaction_handle_voted');
					  		}
						});
					// }
					 
				},
				onSlide: function(v) {
					cpUpdater.disableAJAX();
				}
			});

			cpUpdater.sliders[<?=$v['user_id']?>] = slider;

		// ]]>
		</script>	
	<? endforeach; ?>
</table>


