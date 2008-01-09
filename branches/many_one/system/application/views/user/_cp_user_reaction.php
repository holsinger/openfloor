<table>
	<tr>
		<th class="candidate">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Speaker&nbsp;&nbsp;&nbsp;&nbsp;</th>
		<th style="background-color:#08397b;">Your Reaction</th>
		<th class="reaction">Overall</th>
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