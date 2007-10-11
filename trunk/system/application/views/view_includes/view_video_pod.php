<div class="news-summary" id="xnews-5">
	<!-- raiting topics start here -->
	<div class="raiting" >
		<span id="xvote-5" class="next_invisible">
			<? if ($voted == 'up'): ?>
				<a class="voteup">voted</a>			
			<? else: ?>
				<a href="javascript:queueUpdater.vote(site_url + '/video/voteup/event/<?= url_title($event_name); ?>/video/<?= url_title($video_title); ?>','xnews-<?= $video_id; ?>');" class="up">up</a>
			<? endif; ?>	
		</span>
		<span id="xvote-5" class="next_invisible">
			<? if ($voted == 'down'): ?>
				<a class="votedown">voted</a>			
			<? else: ?>
				<a href="javascript:queueUpdater.vote(site_url + '/video/votedown/event/<?= url_title($event_name); ?>/video/<?= url_title($video_title); ?>','xnews-<?= $video_id; ?>');" class="down">down</a>
			<? endif; ?>	
		</span>
		<a id="xvotes-<?= $video_id; ?>" class="vote_digit"><?=(is_numeric($votes))?$votes:0;?></a>
	</div>
																					
	<div class="describtion">
		<div class="describtion-frame">
			<div class="descr-tr">
				<div class="descr-bl">
					<div class="descr-br">
							<h3>
								<?=anchor("video/view/".url_title($event_name) . '/' . url_title($video_title),$video_title);?>
							</h3>
							<div class="author">
								<div id='ytvid_<?=$video_youtude_id;?>' class="video">						
										<span class='link' onClick="ajaxVideo.playYouTubeVideo('<?=$video_youtude_id;?>')"><img src='<?=$video_thumb;?>'></span>
								</div>
								<!-- -->
								<p>Posted by: <?=anchor("user/profile/{$user_name}",$user_name) . ' ('.'5'.' ago)';?>
									<span id="ls_story_link-<?= $video_id; ?>"></span>
								</p>
								<p>
									Event: <?=anchor("forums/queue/event/".url_title($event_name),$event_name);?><span id="ls_adminlinks-5" style="display:none"></span>
								</p>
								<? if(isset($tags)): ?>
								<p>Tags: <? foreach($tags as $tag) echo "<a class=\"link\">$tag</a>, "?></p>
								<? endif; ?>
								<!-- -->
								<p class='video_desc'><?=substr($video_desc,0,150);?>... <a href="index.php/video/queue/<?= $event_url; ?>/video/<?= url_title($video_title); ?>" class="more"> read more &raquo;</a></p>
							</div>
						
						<ul class="options">
							<li class="play_video"><a class='link' onClick="ajaxVideo.playYouTubeVideo('<?=$video_youtude_id;?>')">Play Video</a></li>
							<li class="discuss"><?=anchor("index.php/video/queue/$event_url/video/" . url_title($video_title), 'Discuss')?></li> 	
							<li class="tell-friend" id="ls_recommend-5"><a href="javascript://" onclick="show_recommend(5, 58, '<?= $this->config->site_url();?>');">Tell a friend</a></li>
						</ul>
						<span id="emailto-5" style="display:none"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<? if ($this->userauth->isAdmin()) echo "<div style='float:right;'>".anchor('video/edit/'.$video_id, 'edit')."</div>"; ?>
</div>