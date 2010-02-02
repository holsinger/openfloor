<table>	
	<th>Question</th>	
	<? foreach($last_10_questions as $question): ?>
	<tr><td><?= $question->question_name ?></td></tr>	
	<? endforeach; ?>
</table>