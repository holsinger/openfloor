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

<!-- <div class="question-pod">
	<div class="score"><?= $question['votes'] ?></div>
	<div class="vote">
		<img src="./images/ucp/vote-up.jpg"/>
		<img src="./images/ucp/vote-down.jpg"/>
	</div>
	<div class="question"><?= $question['question_name'] ?></div>
</div>
<div id="cp-comments-<?= $question['question_id'] ?>" class="cp-comments" style="display:none; height: 300px; overflow: scroll;">
</div>
<div id="cp-votes-<?= $question['question_id'] ?>" class="cp-votes" style="display:none; height: 300px; overflow: scroll;">
</div>
<div class="votes" onClick="cpUpdater.viewVotes(<?= $question['question_id'] ?>)">votes</div>
<div class="comments" onClick="cpUpdater.viewComments(<?= $question['question_id'] ?>, event_name, '<?= url_title($question['question_name']) ?>')">comments</div> -->

<div class="question-pod-container">
  <b class="question-pod0">
  <b class="question-pod1"><b></b></b>
  <b class="question-pod2"><b></b></b>
  <b class="question-pod3"></b>
  <b class="question-pod4"></b>
  <b class="question-pod5"></b></b>

  <div class="question-podfg">
	<div class="score"><?= $question['votes'] ?></div>
	<div class="vote">
		<img src="./images/ucp/vote-up.jpg"/>
		<img src="./images/ucp/vote-down.jpg"/>
	</div>
	<div class="question"><?= $question['question_name'] ?></div>
	<div style="clear:both;"></div>
  </div>

  <b class="question-pod0">
  <b class="question-pod5"></b>
  <b class="question-pod4"></b>
  <b class="question-pod3"></b>
  <b class="question-pod2"><b></b></b>
  <b class="question-pod1"><b></b></b></b>
  <div id="cp-comments-<?= $question['question_id'] ?>" class="cp-comments" style="display:none; height: 300px; overflow: auto;"></div>
  <div id="cp-votes-<?= $question['question_id'] ?>" class="cp-votes" style="display:none; height: 300px; overflow: auto;"></div>
</div>
<div id='tabs'>
  <div class="votes" onClick="cpUpdater.viewVotes(<?= $question['question_id'] ?>)">votes</div>
  <div class="comments" onClick="cpUpdater.viewComments(<?= $question['question_id'] ?>, event_name, '<?= url_title($question['question_name']) ?>')">comments</div>
</div>




<? 	endforeach; ?>	