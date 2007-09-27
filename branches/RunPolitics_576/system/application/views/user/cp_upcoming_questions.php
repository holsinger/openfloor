<?	// foreach($questions as $question): 
	// 	$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ;
	// 	echo "	<div class='queue-question'>
	// 				<span class=\"votes\">
	// 					<p>{$question['votes']} $votes <span class=\"votebox\">"; 
	// 					$this->load->view(	'view_includes/votebox_inline.php', 
	// 										array(	'question_id' => $question['question_id'], 
	// 												'voted' => $question['voted'],
	// 												'event_url' => "event/$event", 
	// 												'question_name' => $question['question_name']));
	// 	echo "			</span></p>
	// 				</span>
	// 				<span class=\"question\">{$question['question_name']}</span>
	// 			</div>
	// 			<div id=\"cp-comments-{$question['question_id']}\" class=\"cp-comments\" style=\"display:none; height: 300px; overflow: scroll;\">
	// 				[comments view]
	// 			</div>
	// 			<div id=\"cp-votes-{$question['question_id']}\" class=\"cp-votes\" style=\"display:none; height: 300px; overflow: scroll;\">
	// 				[votes view]
	// 			</div>
	// 			<span class=\"cp-comments-tab\" onClick=\"cpUpdater.viewComments({$question['question_id']}, event_name, '" . url_title($question['question_name']) . "')\">comments</span>
	// 			<span class=\"cp-votes-tab\" onClick=\"cpUpdater.viewVotes({$question['question_id']})\">votes</span>
	// 			<br />";
	// endforeach;	?>
	
<? 	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ; ?>

<div class="question-pod">
	<div class="score"><?= $question['votes'] ?></div>
	<div class="vote">
		<img src="./images/ucp/vote-up.jpg"/>
		<img src="./images/ucp/vote-down.jpg"/>
	</div>
	<div class="question"><?= $question['question_name'] ?></div>
	<div class="votes">votes</div>
	<div class="comments">comments</div>
</div>

<? 	endforeach; ?>	