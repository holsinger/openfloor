<table>
	<tr>
		<th class="sp_arrow"></th>
		<th class="candidate">&nbsp;&nbsp;Respondents</th>
		<th class="reaction">&nbsp;&nbsp;</th>
	</tr>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
		<tr<?=$class?>>
			<td class="sp_arrow" id="current_area_<?=$v['user_id']?>"></td>
			<td colspan="2"><?= $v['avatar'] . '&nbsp;' . $v['link_to_profile'] ?></td>
		</tr>
	<? endforeach; ?>
</table>


