<a><h3>When you answer questions, students rate how well they think you answered their question. These are the questions you answered the associated feedback from students.</h3></a>
<br/>
<h3>Last 10 answered questions</h3>
<?= anchor("user/all/answered/$user_name", 'See all') ?>
<table class="user-profile">
	<tr>
		<th>Question</th>
		<th>Answer</th>
		<th>Rate</th>
	</tr>
	<? $rowClass = 'normal'; foreach($feedback as $k => $v): ?>
	<tr class="<?=$rowClass?>">
		<td><?=$v['question_name']?></td>
		<td><?=$v['answer']?></td>
		<td><?=$v['rate']?></td>
	</tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; ?>
	<? endforeach; ?>
</table>