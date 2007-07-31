<?
$data['red_head'] = $event_type;
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = "event/".url_title($event_name);

$this->load->view('view_includes/header.php',$data);
?>
<div class="news-summary" id="xnews-<?= $question_id; ?>">
	<!-- raiting topics start here -->
	<div class="raiting" >
		<span id="xvote-<?= $question_id; ?>" class="next_invisible">
			<? if ($voted == 'up') { ?>
				<a class="voteup">voted</a>			
			<? } else { ?>
				<!-- <a href="index.php/question/voteup/<?= url_title($event_name); ?>/question/<?= url_title($question_name); ?>" class="up">up</a> -->
				<!-- span, class link -->
				<a href="javascript:queueUpdater.vote(site_url + '/question/voteup/<?= url_title($event_name); ?>/question/<?= url_title($question_name); ?>','xnews-<?= $question_id; ?>');" class="up">up</a>
			<? } ?>	
		</span>
		<span id="xreport-<?= $question_id; ?>">
			<? if ($voted == 'down') { ?>
				<a class="votedown">voted</a>			
			<? } else { ?>
				<!-- <a href="index.php/question/votedown/<?= url_title($event_name); ?>/question/<?= url_title($question_name); ?>" class="down">down</a> -->
				<a href="javascript:queueUpdater.vote(site_url + '/question/votedown/<?= url_title($event_name); ?>/question/<?= url_title($question_name); ?>','xnews-<?= $question_id; ?>');" class="down">down</a>
			<? } ?>
		</span>
		<a id="xvotes-<?= $question_id; ?>" href="index.php/votes/who/<?= $question_id; ?>" class="vote_digit" title='Who Voted?'><?=(is_numeric($votes))?$votes:0;?></a>
		<!-- <a id="xvotes-<?= $question_id; ?>" class="vote_digit"><?=(is_numeric($votes))?$votes:0;?></a> -->
	</div>
																					
	<div class="describtion">
		<div class="describtion-frame">
			<div class="descr-tr">
				<div class="descr-bl">
					<div class="descr-br">
							<h3><!-- <a href="index.php/question/queue/<?= url_title($event_name); ?>/question/<?= url_title($question_name); ?>"><?=$question_name;?></a> -->
								<?=anchor("question/view/".url_title($event_name) . '/' . url_title($question_name),$question_name);?>
							</h3>
							<div class="autor">
								<span style:"float:left;"><img src="<?=$avatar_path;?>"></span>
								<p>Posted by: <?=anchor("user/profile/{$user_name}",$user_name) . ' (' . $time_diff.' ago)';?>
									<span id="ls_story_link-<?= $question_id; ?>"></span>
								</p>
								<p>
									Event: <?=anchor("conventionnext/queue/event/".url_title($event_name),$event_name);?><span id="ls_adminlinks-5" style="display:none"></span>
								</p>
								<p>
									Tags: <? foreach($tags as $tag) echo anchor("conventionnext/queue/event/".url_title($event_name)."/tag/".$tag,$tag);?>
								</p>
							</div>
						<p><?=$question_desc;?></p>
						<ul class="options">
							<li class="discuss"><?=anchor("question/view/".url_title($event_name) . '/' . url_title($question_name),'Discuss');?></li>		
							<li class="votes"><?=anchor("votes/who/{$question_id}"," Votes");?></li> 	
							<!--  <li class="tell-friend" id="ls_recommend-5"><a href="javascript://" onclick="show_recommend(5, 58, '<?= $this->config->site_url();?>');">Tell a friend</a></li> -->
						</ul>
						<div id="comments">
							<?=isset($comments_body)?$comments_body.'<br/>':''?>
						</div>
						<?
						$attributes = array('class' => 'txt', 'name' => 'comment', 'rows' => 3, 'cols' => 48);
						$submit = ($this->userauth->isUser()) ? 
						'<input type="submit" value="Submit Comment" class="button"/>' : 
						'<input type=\'button\' onclick="showBox(\'login\');" value=\'Login to comment\' class=\'button\'/>';

						$comments = '<div id="comment_add"><div class="comment_head"><strong>';
							if ($this->session->userdata('user_name')>0) $comments .= anchor("user/profile/{$this->session->userdata('user_name')}",$this->session->userdata('user_name'));
							$comments .= ' why not add to the discussion?</strong></div><br />'
							. form_open('comment/addCommentAction')
								. form_textarea($attributes)
								. form_hidden('fk_question_id', $question_id)
								. form_hidden('event_name', url_title($event_name))
								. form_hidden('question_name', $question_name)
								. form_hidden('event_type', 'question')
								. "<br /><br />{$submit}"
							. form_close()
						. '<br /><br /></div>';			
						echo $comments;
						?>			
					</div>
				</div>
			</div>
		</div>
	</div>
	<? if ($this->userauth->isAdmin()) echo "<div style='float:right;'>".anchor('question/edit/'.$question_id, 'edit')."</div>"; ?>
</div>
<?
$this->load->view('view_includes/footer.php');
?>
	