<h3>Last 10 answered questions</h3>
<?= anchor("user/all/answered/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Event</th>
		<th>Question</th>
		<th>Type</th>
		<th>Option</th>
	</tr>
	<? $rowClass = 'normal'; 
	//print_r($attention);
	foreach($attention as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['event_name']?></td>
		<td><?=$v['question_name']?></td>
		<td><?=$v['type']?></td>
		<td><?= anchor("flag/attentionOption/" . $v['question_id'] . "/" . $v['flag_id'] . "/" . $v['type_id'] . "/agree/" . $v['object_question_id'],'Agree')?>&nbsp;&nbsp;
			<?= anchor("flag/attentionOption/" . $v['question_id'] . "/" . $v['object_question_id'] . "/" . $v['flag_id'] . "/" . $v['type_id'] . "/disagree",'Disagree')?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; ?>
	<? endforeach; ?>
</table>