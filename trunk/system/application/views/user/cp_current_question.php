<? if(!empty($current_question)): ?>	
<div class="current-question-pod">
	<b class="question-pod0">
	<b class="question-pod1"><b></b></b>
	<b class="question-pod2"><b></b></b>
	<b class="question-pod3"></b>
	<b class="question-pod4"></b>
	<b class="question-pod5"></b></b>
	<div class="question-podfg">
		<div class="score"><?= $current_question[0]['votes'] ?></div>
		<div class="vote"><? $this->load->view('user/_cp_vote_box', $current_question[0]) ?></div>
		<div class="question"><?=$current_question[0]['question_name']?></div>
		<div id="question-cover" class="question-cover"></div>
		<div style="clear:both;"></div>
		<div id="cp-comments-<?= $current_question[0]['question_id'] ?>" class="cp-comments" style="height:300;display:none;overflow:auto;">COMMENTS</div>
		<div id="cp-votes-<?= $current_question[0]['question_id'] ?>" class="cp-votes" style="height:300;display:none;overflow:auto;">VOTES</div>
	</div>
	<b class="question-pod0">
	<b class="question-pod5"></b>
	<b class="question-pod4"></b>
	<b class="question-pod3"></b>
	<b class="question-pod2"><b></b></b>
	<b class="question-pod1"><b></b></b></b>
</div>
<div class="votes" onClick="cpUpdater.viewVotes(<?= $current_question[0]['question_id'] ?>)"><?= $current_question[0]['vote_count'] ?> votes</div>
<div class="comments" onClick="cpUpdater.viewComments(<?= $current_question[0]['question_id'] ?>, event_name, '<?= url_title($current_question[0]['question_name']) ?>')"><?= $current_question[0]['comment_count'] ?> comments</div>
<div style="clear:both;"></div>
<? else: ?>
There is no current question
<? endif; ?>