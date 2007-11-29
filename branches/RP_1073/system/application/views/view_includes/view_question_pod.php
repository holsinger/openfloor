<!--
	#dependency queueUpdater.js
	#dependency popup.js
	#dependency question.css
-->
<? $profileLink = "user/profile/$user_name" ?>
<div class="news-summary" id="xnews-<?= $question_id; ?>">
	<!-- Voting Section -->
	<? /*
	<div class="raiting" >
			<? $this->load->view('view_includes/votebox.php')?>
			<a id="xvotes-<?= $question_id; ?>" href="index.php/votes/who/<?= $question_id; ?>" class="vote_digit" title='Who Voted?'><?=(is_numeric($votes))?$votes:0;?></a>
		</div>
	*/
	?>
	
	<!-- Right Section -->
	<div class="describtion">
		<div class="describtion-frame">
			<div class="descr-tr">
				<div class="descr-tl">
					<div class="descr-bl">
						<div class="descr-br">
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height: 5px;"></td></tr>
									<tr>
										<td class='vote_box' valign="middle">
											<h3 title='Question Score'><?=anchor("votes/who/{$question_id}", (is_numeric($votes))?$votes:0 );?></h3>
										</td>
										<td style="padding-left: 5px;" valign="top">
											<h3>
											<? if($view_name == 'question_view') {
											   		echo $question_name;
											} else { 
													echo anchor("question/view/".url_title($event_name) . '/' . url_title($question_name),$question_name); 
											} ?>
											</h3>
										</td>
									</tr>
								</table>
								<div class="autor">
									<? //$this->flag_lib->type = 'user'; 		$this->load->view('view_includes/flag.php'); ?>
									<span style:"float:left;"><a href="<?=site_url($profileLink)?>"><img src="<?=$avatar_path;?>"></a></span>
									<p>
										Posted by: <?=anchor($profileLink, $display_name) . ' (' . $time_diff.' ago)';?>
										<span id="ls_story_link-<?= $question_id; ?>"></span>
									</p>
									<p>
										Event: <?=anchor("forums/cp/".url_title($event_name),$event_name);?><span id="ls_adminlinks-5" style="display:none"></span>
									</p>
									<p>
										Tags: <? if(!empty($tags)) echo implode(', ',$tags);?>
									</p>
								</div>
							<? if ($view_name == 'question_view'): ?>
								<p><?=$question_desc;?></p>
							<? else: ?>	
								<p><?=substr($question_desc,0,150);?> <?=anchor("question/view/".url_title($event_name)."/".url_title($question_name), "read more&raquo;","class='more'");?></p>
							<? endif; ?>
							<ul class="options">
								<li class="discuss"><?=anchor("question/view/".url_title($event_name) . '/' . url_title($question_name), $comment_count . ' Comments');?></li>
								<li class="votes"><?=anchor("votes/who/{$question_id}", '&nbsp;' . $vote_count . ' Votes');?></li>
								
								<!-- <? if($this->userauth->isUser()): ?>
								<li class="flag"><a href="<?="javascript:queueUpdater.toggleVisibility('flag_question$question_id');"?>">Flag</a></li>
								<? else: ?>
								<li class="flag"><a href="javascript: var none = showBox('login');">Flag</a></li>
								<? endif; ?> -->
								<? if($question_status == 'asked' && !empty($question_answer)): ?>
								<li class="watch"><a id="popup_<?= $question_id ?>" class="link" onclick="new Ajax.Updater('hack_<?= $question_id ?>', site_url + 'forums/watch_answer/<?= $question_id ?>')">Watch</a></li>
								<!-- <li class="watch"><a class="link" onclick="queueUpdater.toggleVisibility('watch_question_<?= $question_id ?>')">Watch</a></li> -->
								<!-- <li class="watch"><?= anchor_popup('forums/watch_answer/' . $question_id, 'Watch', array('width' => 450, 'height' => 360, 'scrollbars' => 'no', 'status' => 'no', 'resizable' => 'no')) ?></li> -->
								<? endif; ?>
							
							</ul>

	<!-- hidden div used to be here... -->
							<? if($view_name == 'question_view') $this->load->view('question/_comments.php') ?>
							<? if($view_name == 'votes_view') echo $voteHTML ?>
							<? if($this->userauth->isUser()): ?>
							<? $this->flag_lib->type = 'question'; echo $this->flag_lib->createFlagHTML($question_id, $event_name, $question_id); ?>
							<? endif; ?>
							<? if($this->userauth->isUser()): ?>
							<? $this->flag_lib->type = 'user'; echo $this->flag_lib->createFlagHTML($user_id, $event_name, $question_id); ?>
							<? endif; ?>		
							<span id="emailto-5" style="display:none"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<? if($question_status == 'asked' && !empty($question_answer)): ?>

<div style="display: none; visibility: hidden;" class="watch_question" id="watch_question_<?= $question_id ?>">
	<!-- <div class="close_flag_window" onClick="javascript:$('watch_question_<?= $question_id ?>').setStyle({display:'none'});"></div> -->
	<div class="close_watch_window" onClick="javascript:$('watch_question_<?= $question_id ?>').setStyle({display:'none',visibility:'hidden'});$('watch_question_<?= $question_id ?>').innerHTML='';"></div>
	<div id="hack_<?= $question_id ?>"><?= $question_answer ?></div>
</div>

<script type="text/javascript" charset="utf-8">
	
	_offset_x = 60;
	_offset_y = -25;
	
	if(navigator.appVersion.indexOf("MSIE") != -1) {
		_offset_x += -30;
		_offset_y += 0;
	}
	
	popup_instance_<?= $question_id ?> = new Control.PopUp(
		'popup_<?= $question_id ?>', 
		{
			offset_x: _offset_x,
			offset_y: _offset_y,
			popup_class: "watch_questions",
			document_hide_event: false,
			ajax_update_url: site_url + 'forums/watch_answer/<?= $question_id ?>'
		}
	);
</script>
<? endif; ?>
<? if ($this->userauth->isAdmin()) echo "<div class='admin-queue-edit-question'>".anchor('question/edit/'.$question_id, 'edit')."</div>"; ?>