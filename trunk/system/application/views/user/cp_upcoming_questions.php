<?	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ;
		echo "	<div class='queue-question'>
					<span class=\"votes\">
						<p>{$question['votes']} $votes <span class=\"votebox\">"; 
						$this->load->view(	'view_includes/votebox_inline.php', 
											array(	'question_id' => $question['question_id'], 
													'voted' => $question['voted'],
													'event_url' => "event/$event", 
													'question_name' => $question['question_name']));
		echo "			</span></p>
					</span>
					<span class=\"question\">{$question['question_name']}</span>
				</div>
				<br />";
	endforeach;	?>