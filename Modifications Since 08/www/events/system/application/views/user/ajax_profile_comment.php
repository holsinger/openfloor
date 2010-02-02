<a><h3>These are the questions you have commented on.</h3></a>
<br/>
<h3>Last 10 comments</h3>
<?= anchor("user/all/comments/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>comments</th>
		<th>Event</th><th>Question</th>
	</tr>
	
	<? $rowClass = 'normal'; 
	foreach($comments as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['comment']?></td>
		<td><?=$v['event_name']?></td>
		<td><?=$v['question_name']?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ;?>
	<? endforeach; ?>
</table>