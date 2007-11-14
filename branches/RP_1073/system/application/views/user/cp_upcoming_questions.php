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
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td><div class="score"><?= $question['votes'] ?></div></td>
			<td><div class="vote"><? $this->load->view('user/_cp_vote_box', $question) ?></div></td>
			<td width="100%"><div class="question"><img class="sc_image" src="./avatars/shrink.php?img=<?= $question['avatar_path'] ?>&w=16&h=16"/>&nbsp;<?= $question['question_name'] ?></div></td>
			<td><div class="flag"><!-- <img src="./images/flag.png"> --></div></td>
		</tr>
	</table>		
	<div id="cp-info-<?= $question['question_id'] ?>" class="cp-info" style="height:300;display:none;overflow:auto;">
		<p><b>Posted By: </b><?= $question['user_name'] ?> <img class="sc_image" src="./avatars/<?= $question['avatar_path'] ?>"/></p>
		<p><b>When: </b>(<?= $question['time_diff'] ?> ago)</p>
		<?= empty($question['tags']) ? '' : '<p><b>Tags: </b>' . implode(', ', $question['tags']) . '</p>' ?>
		<p><b>Description: </b><?= $question['question_desc'] ?></p>	
	</div>
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
<div class="more_info" onClick="cpUpdater.viewInfo('<?= $question['question_id'] ?>')">more info</div>
<div style="clear:both;"></div>

<? 	endforeach; ?>	