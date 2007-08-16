<?//echo '<pre>'; print_r($data); echo '</pre>';?><div class="news-summary" id="xnews-<?= $question_id; ?>">
	<!-- raiting topics start here -->
	<div class="raiting" >
		<? $this->load->view('view_includes/voteBox.php')?>		
		<a id="xvotes-<?= $question_id; ?>" href="index.php/votes/who/<?= $question_id; ?>" class="vote_digit" title='Who Voted?'><?=(is_numeric($votes))?$votes:0;?></a>
	</div>
																					
	<div class="describtion">
		<div class="describtion-frame">
			<div class="descr-tr">
				<div class="descr-bl">
					<div class="descr-br">
							<h3>
								<?=anchor("question/view/".url_title($event_name) . '/' . url_title($question_name),$question_name);?>
							</h3>
							<div class="autor">
								<span style:"float:left;"><img src="<?=$avatar_path;?>"></span>
								<p>Posted by: <?=anchor("user/profile/{$user_name}",$user_name) . ' ('.$time_diff.' ago)';?>
									<span id="ls_story_link-<?= $question_id; ?>"></span>
								</p>
								<!-- <a id="flaglet" style="float:right;" onclick="javascript:new Effect.toggle('flag<?=$question_id?>','blind', {queue: 'end'});"><img src="./images/flag.png"/></a> --><!-- Yes, this is temporary -->
								<p>
									Event: <?=anchor("conventionnext/queue/event/".url_title($event_name),$event_name);?><span id="ls_adminlinks-5" style="display:none"></span>
								</p>
								<p>
									Tags: <? if(!empty($tags)) echo implode(', ',$tags);?>
								</p>
							</div>
						<p><?=substr($question_desc,0,150);?> <?=anchor("question/view/".url_title($event_name)."/".url_title($question_name), "read more&raquo;","class='more'");?></p>
						<ul class="options">
							<li class="discuss"><?=anchor("question/view/".url_title($event_name) . '/' . url_title($question_name), $comment_count . ' Comments');?></li>
							<li class="votes"><?=anchor("votes/who/{$question_id}", $vote_count . " Votes");?></li> 	
							<!--  <li class="tell-friend" id="ls_recommend-5"><a href="javascript://" onclick="show_recommend(5, 58, '<?= $this->config->site_url();?>');">Tell a friend</a></li> -->
						</ul>
						<? if($this->userauth->isUser()): ?>
						<?= $this->flag_lib->createQuestionFlagHTML($question_id); ?>
						<? endif; ?>		
						<span id="emailto-5" style="display:none"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<? if ($this->userauth->isAdmin()) echo "<div style='float:right;'>".anchor('question/edit/'.$question_id, 'edit')."</div>"; ?>
</div>