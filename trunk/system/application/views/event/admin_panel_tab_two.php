<strong>Speakers:</strong>
<table cellpadding="0" cellspacing="0">
	<? if(count($users) > 0): ?>
		<tr>
			<th style="height: 25px; ">&nbsp;Name</th>
		</tr>
		<? foreach($users AS $user): ?>
			<tr>
				<td style="padding: 3px 15px 3px 0px;"><?=$user['can_display_name']?></td>
			</tr>
		<? endforeach; ?>
	<? endif; ?>
</table>
<br /><br /><br />
<input type="button" class="button" onclick="window.location='event/create_event_two/<?=$event_id?>/edit';" value="Edit Information" />