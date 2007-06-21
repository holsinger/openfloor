<p><table width="70%" cellspacing="0" cellpadding="3">
	<tr><td bgcolor="#0066cc" width='175'>
			<table>
				<tr><td><a href="index.php/question/voteup/<?= $question_id; ?>">[+]</a></td><td rowspan='2' align='center'><?=$votes;?><br/>votes</td></tr>
				<tr><td><a href="index.php/question/votedown/<?= $question_id; ?>">[-]</a></td></tr>
			</table>
		</td>
		<td bgcolor="#99ccff"><b><?=$question_name;?></b></td></tr>
	<tr><td bgcolor="#99ccff">Event:<br/><?=$event_name;?></td><td bgcolor="#ccffff"><img src='http://localhost/~Rob/Politic20/images/rob.jpg'/>Posted By: <?=$user_name;?></td></tr>
	<tr><td bgcolor="#99ccff"><img src='images/meet_mitt_romney.jpg' width='52' height='62'/></td><td bgcolor="#ccffff"><?=$question_desc;?></td></tr>
</table></p>