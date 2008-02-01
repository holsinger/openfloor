<? if(isset($current_question_flag) && empty($current_question)): ?>	
	&nbsp;<strong>There is no current question</strong>
<? else: ?>
	<? 	
	if(isset($current_question_flag)) $question = $current_question;
	$count = 0; 	// Used for IE 6 hack
	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ; 
		# IE 6 has this nasty bug where if I don't insert this section below, the first pod for every return will not have it's background applied
		if(($this->agent->browser() == "Internet Explorer" && $this->agent->version() < 7) && $count == 0): ?>
			<div style="overflow: hidden; height: 0px; margin-top: -22px"><img src="http://192.168.0.86/many_one/images/many_one/bg_question_pod.gif" /></div>
		<? endif; ?>
		
		<div class="<?= isset($current_question_flag) ? 'current-question-pod' : 'question-pod-container' ?>" id="question_container_<?= $question['question_id'] ?>">
		  <div class="question-podfg">
			<table cellpadding="0" cellspacing="0" style="margin-top: 5px; margin-bottom: 5px;">
				<tr>
					<?if(!isset($current_question_flag)):?>
						<td style="padding-left: 5px;"><div class="score" title='Question Score'><?= $question['votes'] ?></div></td>
						<? if($question['question_status'] != 'asked' && !$event_data["event_finished"] && !$is_respondent):?>
							<td><div class="vote"><? $this->load->view('user/_cp_vote_box', $question) ?></div></td>
						<? endif; ?>
					<?else:?>
						<td><div class="flag"><!-- <img src="./images/flag.png"> --></div></td>
					<?endif;?>
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
			<div id="cp_tab_body_<?= $question['question_id'] ?>" class="cp-comments" style="display:none;overflow:auto;"></div>	
		  </div>
		</div>
		<!-- TABS -->
		<div id="cp_votes_tab_<?= $question['question_id'] ?>" class="votes" title="Vote History" onClick="cpUpdater.view_tab_section('votes',<?= $question['question_id'] ?>)"><?= $question['vote_count'] ?> votes</div>
		<div id="cp_comments_tab_<?= $question['question_id'] ?>" class="comments" title="Comments" onClick="cpUpdater.view_tab_section('comments', <?= $question['question_id'] ?>, event_name, '<?= url_title($question['question_name']) ?>', this)"><?= $question['comment_count'] ?> comments</div>
		<div id="cp_info_tab_<?= $question['question_id'] ?>" class="info" title="More Info" onClick="cpUpdater.view_tab_section('info', '<?= $question['question_id'] ?>')">more info</div>
		<? if($question['question_answer']): ?>
			<div id="cp_answer_tab_<?= $question['question_id'] ?>" class="answer" title="Answer" onClick="cpUpdater.view_tab_section('answer','<?= $question['question_id'] ?>');">Answer</div>
		<? endif; ?>
		<? if($this->userauth->isEventAdmin($event_id)): ?>
			<div id="cp_admin_tab_<?= $question['question_id'] ?>" class="admin" title="Admin" onClick="cpUpdater.view_tab_section('admin','<?= $question['question_id'] ?>', <?=$event_id?>);">Admin</div>
		<? endif; ?>
		<div style="clear:both;"></div>
		<? $count++; ?>
	<? 	endforeach; ?>
<? endif; ?>