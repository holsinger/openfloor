<a><h3><?=$explanation?></h3></a>
<br/>
<h3>Last 10 flags</h3>
<?= anchor("user/all/flags/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Question</th>
		<th>Event</th>
		<th>flags</th>
	</tr>
	
	<? $rowClass = 'normal'; 
	foreach($flags as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['question_name']?></td>
		<td><?=$v['event_name']?></td>
		<td><?=$v['type']?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ;?>
	<? endforeach; ?>
</table>