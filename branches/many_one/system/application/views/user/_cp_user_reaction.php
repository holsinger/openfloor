<table>
	<tr>
		<th class="candidate">&nbsp;&nbsp;Speaker</th>
		<th style="background-color:#3561b7;">Your Reaction</th>
		<th class="reaction">Overall&nbsp;&nbsp;</th>
	</tr>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
		<tr<?=$class?>>
			<td><?= $v['avatar'] . '&nbsp;' . $v['link_to_profile'] ?></td>
			<td><div id="your-reaction-<?=$v['user_id']?>"><?$this->load->view('user/_userReactSlider', $v)?></div></td>
			<td><div id="overall-reaction-<?=$v['user_id']?>"><?$this->load->view('user/_overallReaction', $v)?></div></td>
		</tr>
	<? $class = $class ? '' : ' class="alternate"' ?>
	<? endforeach; ?>
</table>