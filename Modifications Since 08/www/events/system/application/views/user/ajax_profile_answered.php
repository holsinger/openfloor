<a><h3>These are questions you asked that were answered!</h3></a>
<br/>
<h3>Last 10 answered questions</h3>
<?= anchor("user/all/answered/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Event</th>
		<th>Question</th>
		<th>Answer</th>
	</tr>
	<? $rowClass = 'normal'; foreach($answered as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['event_name']?></td>
		<td><?=$v['question_name']?></td>
		<td><?=$v['question_answer']?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; ?>
	<? endforeach; ?>
</table>