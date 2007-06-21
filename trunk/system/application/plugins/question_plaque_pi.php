<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function create_plaque($question)
{
	$baseurl		= "http://localhost/~Rob/Politic20/index.php/question";
	$voteUpURL 		= "$baseurl/voteup/{$question['question_id']}";
	$voteDownURL 	= "$baseurl/votedown/{$question['question_id']}";
	
	
	return "<p><table width=\"70%\" cellspacing=\"0\" cellpadding=\"3\">
				<tr><td bgcolor=\"#0066cc\" width='175'>
						<table>
							<tr><td><a href=\"$voteUpURL\">[+]</a></td><td rowspan='2' align='center'>{$question['votes']}<br/>votes</td></tr>
							<tr><td><a href=\"$voteDownURL\">[-]</a></td></tr>
						</table>
					</td>
					<td bgcolor=\"#99ccff\"><b>{$question['question_name']}</b></td></tr>
				<tr><td bgcolor=\"#99ccff\">Event:<br/>{$question['event_name']}</td><td bgcolor=\"#ccffff\"><img src='http://localhost/~Rob/Politic20/images/rob.jpg'/>Posted By: {$question['user_name']}</td></tr>
				<tr><td bgcolor=\"#99ccff\"><img src='http://localhost/~Rob/Politic20/images/meet_mitt_romney.jpg' width='52' height='62'/></td><td bgcolor=\"#ccffff\">{$question['question_desc']}</td></tr>
			</table></p>";
}