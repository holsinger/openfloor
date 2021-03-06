<table>
	<br/>
	<div class="sectionSmall"><h3>Respondent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Reaction&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Overall</h3></div>
	<p><?=$msg?></p>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
		<tr<?=$class?>>
			<? if ($this->config->item('respondent_interface')):?>
				<td class="sp_arrow" id="current_area_<?=$v['user_id']?>"></td>
			<? else: ?>
				<td></td>
			<? endif; ?>	
			<td><?= $v['avatar'] . '&nbsp;' . $v['link_to_profile'] ?></td>
			<td>
				<div id="your-reaction-<?=$v['user_id']?>">
					<div id="track<?=$v['user_id']?>" class="track" style="width:130px; height:9px;">
							<div id="handle-img-<?=$v['user_id']?>" class="<?=($v['user_reaction'] == -1)?"reaction_handle":"reaction_handle_voted"?>"></div>
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
			cpUpdater.current_question_id = <?= empty($current_question) ? 0 : $current_question[0]['question_id'] ?>;
			// horizontal slider control
			slider = new Control.Slider('handle-img-<?=$v['user_id']?>', 'track<?=$v['user_id']?>', {
				range:$R(0,10),
				values:[0,1,2,3,4,5,6,7,8,9,10]
			});
			cpUpdater.sliders[<?=$v['user_id']?>] = slider;
		</script>	
	<? endforeach; ?>
	<tr>
		<td></td>
		<td colspan="3">
			<div id="user_reaction_ajax"></div>
		</td>
	</tr>
</table>


