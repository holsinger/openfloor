<a><h3><?=$explanation?></h3></a>
<br/>
<h3>Last 10 questions</h3>
<?= anchor("user/all/questions/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Event</th>
		<th>Question</th>
	</tr>
	<? $rowClass = 'normal'; foreach($questions as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['event_name']?></td>
		<td><?=$v['question_name']?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; ?>
	<? endforeach; ?>
</table>