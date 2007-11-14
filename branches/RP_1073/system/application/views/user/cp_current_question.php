<? if(!empty($current_question)): ?>	
<div class="current-question-pod">
	<b class="question-pod0">
	<b class="question-pod1"><b></b></b>
	<b class="question-pod2"><b></b></b>
	<b class="question-pod3"></b>
	<b class="question-pod4"></b>
	<b class="question-pod5"></b></b>
	<div class="question-podfg">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td><div class="score"><?= $current_question[0]['votes'] ?></div></td>
				<td><div class="vote"><? $this->load->view('user/_cp_vote_box', $current_question[0]) ?></div></td>
				<td width="100%"><div class="question" id="the-current-question"><img class="sc_image" src="./avatars/shrink.php?img=<?= $current_question[0]['avatar_path'] ?>&w=16&h=16"/>&nbsp;<?=$current_question[0]['question_name']?></div></td>
				<td><div class="flag"><!--<img src="./images/flag.png">--></div></td>
			</tr>
		</table>		
		<div id="cp-info-<?= $current_question[0]['question_id'] ?>" class="cp-info" style="height:300;display:none;overflow:auto;">
			<p><b>Posted By: </b><?= $current_question[0]['user_name'] ?> <img class="sc_image" src="./avatars/<?= $current_question[0]['avatar_path'] ?>"/></p>
			<p><b>When: </b>(<?= $current_question[0]['time_diff'] ?> ago)</p>
			<?= empty($current_question[0]['tags']) ? '' : '<p><b>Tags: </b>' . implode(', ', $current_question[0]['tags']) . '</p>' ?>
			<p><b>Description: </b><?= $current_question[0]['question_desc'] ?></p>	
		</div>
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
<div class="more_info" onClick="cpUpdater.viewInfo('<?= $current_question[0]['question_id'] ?>')">more info</div>
<div style="clear:both;"></div>
<? else: ?>
There is no current question
<? endif; ?>