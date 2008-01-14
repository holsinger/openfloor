<table>
	<tr>
		<th width="110" class="candidate">&nbsp;&nbsp;Speaker</th>
		<th width="150" style="background-color:#3561b7;">Your Reaction</th>
		<th width="90" class="reaction">Overall&nbsp;&nbsp;</th>
	</tr>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
		<tr<?=$class?>>
			<td width="110"><?= $v['avatar'] . '&nbsp;' . $v['link_to_profile'] ?></td>
			<td width="150"><div id="your-reaction-<?=$v['user_id']?>"><?$this->load->view('user/_userReactSlider', $v)?></div></td>
			<td width="90"><div id="overall-reaction-<?=$v['user_id']?>"><?$this->load->view('user/_overallReaction', $v)?></div></td>
		</tr>
	<? $class = $class ? '' : ' class="alternate"' ?>
	<? endforeach; ?>
</table>