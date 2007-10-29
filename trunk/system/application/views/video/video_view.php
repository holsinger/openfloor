<!--
	#dependency /queueUpdater.js
	#dependency /ajaxVideo.js
-->
<?
$data['red_head'] = $event_type;
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = "event/".url_title($event_name);
$data['left_nav'] = 'event';

$this->load->view('view_includes/header.php',$data);
?>
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
				<a class="voteup">voted</a>			
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
							<h3><span class="link"><?=$video_title;?></span></h3>
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
								<p class='video_desc'><?=$video_desc;?></p>
							</div>
							<br>
						<ul class="options">
							<li class="play_video"><a class='link' onClick="ajaxVideo.playYouTubeVideo('<?=$video_youtude_id;?>')">Play Video</a></li>
							<li class="discuss"><?=anchor("video/queue/event/$event_name/video/" . url_title($video_title), 'Discuss')?></li> 	
							<li class="tell-friend" id="ls_recommend-5"><a href="javascript://" onclick="show_recommend(5, 58, '<?= $this->config->site_url();?>');">Tell a friend</a></li>
						</ul>
						<br /><br /><br /><br />
						<div id="comments">
							<?=isset($comments_body)?$comments_body.'<br/>':''?>
						</div>
						<?
						$attributes = array('class' => 'txt', 'name' => 'comment', 'rows' => 3, 'cols' => 48);
						$submit = ($this->userauth->isUser()) ? 
						'<input type="submit" value="Submit Comment" class="button"/>' : 
						'<input type="button" onclick="showBox(\'login\');" value="Login to comment" class="button"/>';

						$comments = '<div id="comment_add"><div class="comment_head"><strong>';
							if ($this->userauth->user_name>0) $comments .= anchor("user/profile/{$this->userauth->user_name}",$this->userauth->user_name);
							$comments .= ' why not add to the discussion?</strong></div><br />'
							. form_open('comment/addCommentAction')
								. form_textarea($attributes)
								. form_hidden('fk_video_id', $video_id)
								. form_hidden('event_name', url_title($event_name))
								. form_hidden('name', $video_title)
								. form_hidden('event_type', 'video')
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
	<? if ($this->userauth->isAdmin()) echo "<div style='float:right;'>".anchor('video/edit/'.$video_id, 'edit')."</div>"; ?>
</div>
<?
$this->load->view('view_includes/footer.php');
?>