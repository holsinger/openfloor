<table>
	<tr><th class="candidate">Candidate</th><th class="reaction">Your Reaction</th></tr>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
	<tr<?=$class?>>
		<td><?= $v['avatar'] . '<br/>' . $v['link_to_profile'] ?></td>
		<td><div id="your-reaction-<?=$v['can_id']?>"><?$this->load->view('user/_userReactSlider', $v)?></div></td>
	</tr>
	<? $class = $class ? '' : ' class="alternate"' ?>
	<? endforeach; ?>
</table>