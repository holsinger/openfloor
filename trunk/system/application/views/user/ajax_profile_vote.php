<h3>Last 10 votes</h3>
<?= anchor("user/all/votes/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Voted</th>
		<th>Event</th><th>Question</th>
	</tr>
	<? $rowClass = 'normal'; 
	foreach($votes as $k => $v): ?>
	<? $vote_value = ($v['vote_value'] > 0) ? '<img src="./images/thumbsUp.png">' : '<img src="./images/thumbsDown.png">'; ?>
	<tr class="<?=$rowClass?>">
		<td><?=$vote_value?></td>
		<td><?=$v['event_name']?></td>
		<td><?=$v['question_name']?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ;?>
	<? endforeach; ?>
</table>