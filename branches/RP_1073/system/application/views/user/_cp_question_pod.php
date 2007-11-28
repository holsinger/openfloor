<? if(isset($current_question_flag) && empty($current_question)): ?>	
	&nbsp;<strong>There is no current question</strong>
<? else: ?>

<? 	
if(isset($current_question_flag)) $question = $current_question;
	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ; ?>

		<div class="<?= isset($current_question_flag) ? 'current-question-pod' : 'question-pod-container' ?>" id="question_container_<?= $question['question_id'] ?>">
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
					<td width="100%"><div class="question"<?= isset($current_question_flag) ? ' id="the-current-question"' : '' ?>><?= anchor('/user/profile/' . $question['user_name'], '<img class="sc_image" src="./avatars/shrink.php?img='.$question['avatar_path'].'&w=16&h=16"/>');?>&nbsp;<?= $question['question_name'] ?></div></td>
					<td><div class="flag"><!-- <img src="./images/flag.png"> --></div></td>
				</tr>
			</table>		
			<div id="cp-info-<?= $question['question_id'] ?>" class="cp-info" style="display:none;overflow:auto;">
				<div class="close" style=\"position:relative; top:-5px;\"><a class="link" onClick="$('cp-info-<?= $question['question_id'] ?>').setStyle({display: 'none'});">close</a></div>
				<?= anchor('/user/profile/' . $question['user_name'], '<img class="sc_image" src="./avatars/'.$question['avatar_path'].'"/>';?><br />
				<b>Posted By: </b><?= anchor('/user/profile/' . $question['user_name'], $question['user_name']) ?> (<?= $question['time_diff'] ?> ago)<br />
				<?= empty($question['tags']) ? '' : '<b>Tags: </b>' . implode(', ', $question['tags']) . '<br />' ?>
				<b>Description: </b><?= $question['question_desc'] ?><br />
				<div class="close" style=\"position:relative; top:-5px;\"><a class="link" onClick="$('cp-info-<?= $question['question_id'] ?>').setStyle({display: 'none'});">close</a></div>
				<br />	
			</div>
			<div id="cp-comments-<?= $question['question_id'] ?>" class="cp-comments" style="display:none;overflow:auto;">COMMENTS</div>
		    <div id="cp-votes-<?= $question['question_id'] ?>" class="cp-votes" style="display:none;overflow:auto;">VOTES</div>
		  </div>
		  <b class="question-pod0">
		  <b class="question-pod5"></b>
		  <b class="question-pod4"></b>
		  <b class="question-pod3"></b>
		  <b class="question-pod2"><b></b></b>
		  <b class="question-pod1"><b></b></b></b>
		</div>
		<div class="votes" title="Vote History" onClick="cpUpdater.viewVotes(<?= $question['question_id'] ?>)"><?= $question['vote_count'] ?> votes</div>
		<div class="comments" title="Comments" onClick="cpUpdater.viewComments(<?= $question['question_id'] ?>, event_name, '<?= url_title($question['question_name']) ?>')"><?= $question['comment_count'] ?> comments</div>
		<div class="more_info" title="More Info" onClick="cpUpdater.viewInfo('<?= $question['question_id'] ?>')">more info</div>
		<div style="clear:both;"></div>

	<? 	endforeach; ?>
<? endif; ?>