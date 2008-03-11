
<div class="sectionSmall"><h3>Respondents</h3></div>
<p><?=$msg;?></p>
<table>
	<? $class = '' ?>
	<? foreach($candidates as $v): ?>
		<tr<?=$class?>>
			<td class="sp_arrow" id="current_area_<?=$v['user_id']?>"></td>
			<td colspan="2"><?= $v['avatar'] . '&nbsp;' . $v['link_to_profile'] ?></td>
		</tr>
	<? endforeach; ?>
</table>


