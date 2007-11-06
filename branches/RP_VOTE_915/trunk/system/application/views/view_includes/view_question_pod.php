<!--
	#dependency queueUpdater.js
	#dependency question.css
	#dependency voter.js
-->
<? $profileLink = "user/profile/$user_name" ?>
<div class="question-summary" id="xnews-<?= $question_id; ?>">
	<table class="question-table" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td valign="top" class="rating">
				
				<!-- Voting Section -->
					<div id="overall_<?=$question_id?>_rating" class="overall_rating"><?=$votes?></div>
					<div id="user_rating">
						<? for($i = 10; $i >= 0; $i--): ?>
							<div id="meter_<?=$question_id?>_<?=$i?>" class="default_meter"></div>
						<? endfor; ?>
						<div id="result_<?=$question_id?>_div" class="result_div" onclick="VoteScale_<?=$question_id?>.setInitialArrayPos();"><?=$voted?$voted:'N/A'?></div>
						<div id="arrow_<?=$question_id?>_div" class="arrow_div"></div>
					</div>
				
			</td>
			<td class="description">
				
				<!-- Right Section -->
					<div class="description-frame">
						<div class="descr-tr">
							<div class="descr-bl">
								<div class="descr-br">
										<h3 style="color:#f0616a;">
											<? if($view_name == 'question_view') {
											   		echo $question_name;
											} else { 
													echo anchor("question/view/".url_title($event_name) . '/' . url_title($question_name),$question_name); 
											} ?>
										</h3>
										<div class="author">
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
										<li class="votes"><?=anchor("votes/who/{$question_id}", '&nbsp;<span id="vote_count_'.$question_id.'">' . $vote_count . '</span> Votes', array("title" => $vote_count." Votes"));?></li>
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
				
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right"><? if ($this->userauth->isAdmin()) echo "<div class='admin-queue-edit-question'>".anchor('question/edit/'.$question_id, 'edit')."</div>"; ?></td>
		</tr>	
	</table>	
</div>
<script type="text/javascript" charset="utf-8">
	var VoteScale_<?=$question_id?> = new Control.Voter('meter_<?=$question_id?>', {
			voted_meter_class: 'on_meter', arrow_elem: "arrow_<?=$question_id?>_div", arrow_offset_x: 10, start_value: <?=$voted?$voted:0?>,
			onchange : function (value, elem_id){
				$('result_<?=$question_id?>_div').innerHTML = value;
				// Send ajax call to update database and then update update the total result div.
				//queueUpdater.vote(site_url + '/question/vote/<?=$event_url;?>/question/<?=url_title($question_name);?>/rating/'+value, 'total_<?=$question_id?>_results')
				new Ajax.Request('<?=$this->config->site_url()?>question/vote/<?=url_title($event_name)?>/<?=url_title($question_name);?>/'+value, {
					onSuccess: function(transport) {
						Effect.Fade("overall_<?=$question_id?>_rating", {duration: .8, from: 1, to: .2,  queue: 'end',
							afterFinish : function(){
								new Ajax.Updater("overall_<?=$question_id?>_rating", '<?=$this->config->site_url()?>question/getTotalVoteSum/<?=url_title($event_name)?>/<?=url_title($question_name)?>/true', { method: 'get' });
								new Ajax.Updater("vote_count_<?=$question_id?>", '<?=$this->config->site_url()?>question/getVoteCount/<?=$question_id?>', { method: 'get' });
							}
						});	
						Effect.Appear("overall_<?=$question_id?>_rating", {duration: .8, from: .2, to: 1,  queue: 'end'});
					}
				});
			} 
			<? if(!$this->userauth->user_name): ?>
			,onstart : function(){
				if(typeof user_name == 'undefined'){
					showBox('login');
					return false;
				}else {
					return true;
				}
			}
			<? endif; ?>
	});
</script>