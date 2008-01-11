<? if(isset($current_question_flag) && empty($current_question)): ?>	
	&nbsp;<strong>There is no current question</strong>
<? else: ?>

<? 	
if(isset($current_question_flag)) $question = $current_question;
	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ; ?>

		<div class="<?= isset($current_question_flag) ? 'current-question-pod' : 'question-pod-container' ?>" id="question_container_<?= $question['question_id'] ?>">
		  <div class="question-podfg">
			<table cellpadding="0" cellspacing="0" style="margin-top: 5px; margin-bottom: 5px;">
				<tr>
					<td style="padding-left: 5px;"><div class="score" title='Question Score'><?= $question['votes'] ?></div></td>
					<td><div class="vote"><? $this->load->view('user/_cp_vote_box', $question) ?></div></td>
					<td width="100%">
						<div class="question"<?= isset($current_question_flag) ? ' id="the-current-question"' : '' ?>>
							<a href="<?= $this->config->site_url();?>/user/profile/<?=$question['user_name'];?>">
								<img class="sc_image" src="./avatars/shrink.php?img=<?=$question['avatar_path'];?>&w=16&h=16">
							</a>&nbsp;
							<?= $question['question_name'] ?>
						</div>
					</td>
					<td><div class="flag"><!-- <img src="./images/flag.png"> --></div></td>
				</tr>
			</table>
			<div id="cp-admin-<?= $question['question_id'] ?>" class="cp-comments" style="display:none;overflow:auto;">ADMIN</div>		
			<div id="cp-answer-<?= $question['question_id'] ?>" class="cp-comments" style="display:none;overflow:auto;">ANSWER</div>		
			<div id="cp-info-<?= $question['question_id'] ?>" class="cp-comments" style="display:none;overflow:auto;">
				<div class="close" style="position:relative; top:-5px;"><a class="link" onClick="cpUpdater.viewInfo('<?= $question['question_id'] ?>');">close</a></div>
				<a href="<?= $this->config->site_url();?>/user/profile/<?=$question['user_name'];?>"><img class="sc_image" src="./avatars/<?=$question['avatar_path'];?>"/></a><br />
				<strong>Posted By: </strong><?= anchor('/user/profile/' . $question['user_name'], $question['user_name']) ?> (<?= $question['time_diff'] ?> ago)<br />
				<?= empty($question['tags']) ? '' : '<b>Tags: </b>' . implode(', ', $question['tags']) . '<br />' ?>
				<strong>Description: </strong><?= $question['question_desc'] ?><br />
				<? if($question['question_status'] == 'deleted'): ?>
					<strong>Deleted Reason: </strong><?= $question['flag_reason'] ?><br />
					<? if($question['flag_reason'] == 'other'): ?>
						<strong>Other Reason: </strong><?= $question['flag_reason_other'] ?><br />
					<? endif; ?>
				<? endif; ?>
				<div class="close" style="position:relative; top:-5px;"><a class="link" onClick="cpUpdater.viewInfo('<?= $question['question_id'] ?>');">close</a></div>
				<br />	
			</div>
			<div id="cp-comments-<?= $question['question_id'] ?>" class="cp-comments" style="display:none;overflow:auto;">COMMENTS</div>
		    <div id="cp-votes-<?= $question['question_id'] ?>" class="cp-votes" style="display:none;overflow:auto;">VOTES</div>
		  </div>
		</div>
		
		<div class="votes" title="Vote History" onClick="cpUpdater.viewVotes(<?= $question['question_id'] ?>)"><?= $question['vote_count'] ?> votes</div>
		<div class="comments" title="Comments" onClick="cpUpdater.viewComments(<?= $question['question_id'] ?>, event_name, '<?= url_title($question['question_name']) ?>')"><?= $question['comment_count'] ?> comments</div>
		<div class="more_info" title="More Info" onClick="cpUpdater.viewInfo('<?= $question['question_id'] ?>')">more info</div>
		<? if($question['question_answer']): ?>
			<div class="more_info" title="Answer" onClick="cpUpdater.viewAnswer('<?= $question['question_id'] ?>');">Answer</div>
		<? endif; ?>
		<? if($this->userauth->isEventAdmin($event_id)): ?>
			<div class="more_info" title="Admin" onClick="cpUpdater.viewAdmin('<?= $question['question_id'] ?>', <?=$event_id?>);">Admin</div>
		<? endif; ?>
		
		<div style="clear:both;"></div>

	<? 	endforeach; ?>
<? endif; ?>