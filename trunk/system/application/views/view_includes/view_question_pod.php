<?

?>
<div class="news-summary" id="xnews-5">
	<!-- raiting topics start here -->
	<div class="raiting" >
		<span id="xvote-5" class="next_invisible">
			<? if ($voted == 'up') { ?>
				<a class="voteup">voted</a>			
			<? } else { ?>
				<a href="index.php/question/voteup/<?= $event_url; ?>/question/<?= url_title($question_name); ?>" class="up">up</a>
			<? } ?>	
		</span>
		<span id="xreport-<?= $question_id; ?>">
			<? if ($voted == 'down') { ?>
				<a class="votedown">voted</a>			
			<? } else { ?>
				<a href="index.php/question/votedown/<?= $event_url; ?>/question/<?= url_title($question_name); ?>" class="down">down</a>
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
							<h3><a href="index.php/question/queue/<?= $event_url; ?>/question/<?= url_title($question_name); ?>"><?=$question_name;?></a></h3>
							<div class="autor">
								<p>Posted by: <?=anchor("user/profile/{$user_name}",$user_name);?> <!-- 72 days ago -->
									<span id="ls_story_link-<?= $question_id; ?>"></span>
								</p>
								<p>
									Event: <?=anchor("conventionnext/queue/event/".url_title($question_name),$event_name);?><span id="ls_adminlinks-5" style="display:none"></span>
								</p>
							</div>
						<p><?=substr($question_desc,0,150);?>... <a href="index.php/question/queue/<?= $event_url; ?>/question/<?= url_title($question_name); ?>" class="more"> read more &raquo;</a></p>
						<ul class="options">
							<li class="discuss"><a href="index.php/question/queue/<?= $event_url; ?>/question/<?= url_title($question_name); ?>">Discuss</a></li> 	
							<li class="tell-friend" id="ls_recommend-5"><a href="javascript://" onclick="show_recommend(5, 58, '<?= $this->config->site_url();?>');">Tell a friend</a></li>
						</ul>
						<span id="emailto-5" style="display:none"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<? if ($this->userauth->isAdmin()) echo "<div style='float:right;'>".anchor('question/edit/'.$question_id, 'edit')."</div>"; ?>
</div>