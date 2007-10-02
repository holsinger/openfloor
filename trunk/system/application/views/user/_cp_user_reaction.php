<? if (isset($reactionAjax)): ?>
	<? foreach($candidates as $v): ?>
	<? $this->load->view('user/_userReactSlider', $v) ?>
	<? endforeach; ?>
<? else: ?>	
<? if(!empty($current_question)): ?>
<table>
	<tr><th class="candidate">Candidate</th><th class="reaction">Your Reaction</th></tr>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
	<tr<?=$class?>>
		<td><?=$v['can_display_name']?></td>
		<td><div id="your-reaction-<?=$v['can_id']?>"><?$this->load->view('user/_userReactSlider', $v)?></div></td>
	</tr>
	<? $class = $class ? '' : ' class="alternate"' ?>
	<? endforeach; ?>
</table>							
<? endif; ?>
<? endif; ?>
