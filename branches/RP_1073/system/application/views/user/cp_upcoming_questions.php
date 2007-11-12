<? 	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ; ?>

<div class="question-pod-container" id="question_container_<?= $question['question_id'] ?>">
  <b class="question-pod0">
  <b class="question-pod1"><b></b></b>
  <b class="question-pod2"><b></b></b>
  <b class="question-pod3"></b>
  <b class="question-pod4"></b>
  <b class="question-pod5"></b></b>

  <div class="question-podfg">
	<div class="score"><?= $question['votes'] ?></div>
	<div class="vote">
		<? $this->load->view('user/_cp_vote_box', $question) ?>
	</div>
	<div class="question"><?= $question['question_name'] ?></div>
	<div style="clear:both;"></div>
	<div id="cp-comments-<?= $question['question_id'] ?>" class="cp-comments" style="height:300;display:none;overflow:auto;">COMMENTS</div>
    <div id="cp-votes-<?= $question['question_id'] ?>" class="cp-votes" style="height:300;display:none;overflow:auto;">VOTES</div>
  </div>
  <b class="question-pod0">
  <b class="question-pod5"></b>
  <b class="question-pod4"></b>
  <b class="question-pod3"></b>
  <b class="question-pod2"><b></b></b>
  <b class="question-pod1"><b></b></b></b>
</div>
<div class="votes" onClick="cpUpdater.viewVotes(<?= $question['question_id'] ?>)"><?= $question['vote_count'] ?> votes</div>
<div class="comments" onClick="cpUpdater.viewComments(<?= $question['question_id'] ?>, event_name, '<?= url_title($question['question_name']) ?>')"><?= $question['comment_count'] ?> comments</div>
<div style="clear:both;"></div>

<? 	endforeach; ?>	