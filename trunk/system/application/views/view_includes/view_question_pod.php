<!--
	#dependency queueUpdater.js
-->
<? $profileLink = "user/profile/$user_name" ?>
<div class="news-summary" id="xnews-<?= $question_id; ?>">
	<div class="raiting" >
		<? $this->load->view('view_includes/votebox.php')?>
		<a id="xvotes-<?= $question_id; ?>" href="index.php/votes/who/<?= $question_id; ?>" class="vote_digit" title='Who Voted?'><?=(is_numeric($votes))?$votes:0;?></a>
	</div>																					
	<div class="describtion">
		<div class="describtion-frame">
			<div class="descr-tr">
				<div class="descr-bl">
					<div class="descr-br">
							<? $this->flag_lib->type = 'question'; 	$this->load->view('view_includes/flag.php'); ?>
							<h3 style="color:#f0616a;">
								<? if($view_name == 'question_view') {
								   		echo $question_name;
								} else { 
										echo anchor("question/view/".url_title($event_name) . '/' . url_title($question_name),$question_name); 
								} ?>
							</h3>
							<div class="autor">
								<? $this->flag_lib->type = 'user'; 		$this->load->view('view_includes/flag.php'); ?>
								<span style:"float:left;"><a href="<?=site_url($profileLink)?>"><img src="<?=$avatar_path;?>"></a></span>
								<p>
									Posted by: <?=anchor($profileLink, $display_name) . ' (' . $time_diff.' ago)';?>
									<span id="ls_story_link-<?= $question_id; ?>"></span>
								</p>
								<p>
									Event: <?=anchor("forums/queue/event/".url_title($event_name),$event_name);?><span id="ls_adminlinks-5" style="display:none"></span>
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
							<? if($this->userauth->isUser()): ?>
							<li class="flag"><a href="<?="javascript:queueUpdater.toggleVisibility('flag_question$question_id');queueUpdater.toggleQueue();"?>">Flag</a></li>
							<? else: ?>
							<li class="flag"><a href="javascript: var none = showBox('login');">Flag</a></li>
							<? endif; ?>
							<? if($question_status == 'asked' && !empty($question_answer)): ?>
							<li class="watch"><a class="link" onclick="showBox('watch/<?= $question_id ?>')">Watch</a></li>
							<!-- <li class="watch"><?= anchor_popup('forums/watch_answer/' . $question_id, 'Watch', array('width' => 450, 'height' => 360, 'scrollbars' => 'no', 'status' => 'no', 'resizable' => 'no')) ?></li> -->
							<? endif; ?>
							
						</ul>
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
<? if ($this->userauth->isAdmin()) echo "<div class='admin-queue-edit-question'>".anchor('question/edit/'.$question_id, 'edit')."</div>"; ?>