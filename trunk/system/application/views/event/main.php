<?
$cans = ''; foreach($candidates as $v) $cans .= "'{$v['can_id']}', "; $cans = substr($cans, 0, -2);

if($event_data['streaming']){
	$data['js'] = "var event_name = '$event'; var cans = [$cans]; cpUpdater.cpUpdate();";
}else{	// Disable the current questions related periodic updating
	$data['js'] = "var event_name = '$event'; var cans = [$cans]; cpUpdater.cpUpdate(true);";
}

$data['left_nav'] = 'dashboard';
$data['sub_title'] = $event_data['event_name']; 
$this->load->view('view_includes/header.php', $data);
?>
<!-- 
#dependency all2.css
#dependency event.css
#dependency userWindow.css
dependency overall_reaction.css

#dependency cpUpdater.js
#dependency lazy_loader.js
#dependency loading_reminder.js
-->
<? if ($this->userauth->isAdmin()): ?>
	<div><b>Administration:</b></div> 
	<? if(!$event_data["event_finished"]): ?>
		<input value="Next Question" class="button" type="button" onclick="new Ajax.Request(site_url+'forums/next_question/<?=$event_data['event_id']?>',  { onSuccess: function(transport){    }, onFailure: function(){ alert('Could not change question.') } });">
		<input value="Finish Event" class="button" type="button" onclick="new Ajax.Request(site_url+'event/finish_event_ajax/<?=$event_data['event_id']?>',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not end the event.') } });">
	<? endif; ?>
	<input value="Edit Event" class="button" type="button" onclick="window.location=site_url+'event/edit_event/<?=$event_data['event_id']?>'">
	<!-- <a class="link" onclick="cpUpdater.enableAJAX()">START</a>
		<a class="link" onclick="cpUpdater.disableAJAX()">STOP</a>
		<a class="link" onclick="cpUpdater.current_question_fade()">FADE</a> -->
	<br />
	<br />
<? endif; ?>

<div id="ucp">
	<? if(!$event_data['streaming']): ?>
		<div><b>When:</b> <?=date("F j, Y, g:i a", strtotime($event_data['event_date']))?></div>
		<div><b>Where:</b> <?=$event_data["location"]?><br /><br /></div>
	<? endif; ?>
	
	<div><b>Description:</b></div> 
	<div id="event_description"><?=$event_data["event_desc_brief"]?><br /></div>
	<div id="event_description_full" style="display:none; font-weight: normal;">
		<br />Candidates: <?=$event_data['participants']?>
		<br /><?=$event_data["event_desc"]?>
	</div>
	
	<div><br/><a href="javascript: var none = SwithDescription('show');"  title="See Full Description"><span id="description_text">See full description</span></a><br/></div>
	<br />
	<? if(!$event_data["event_finished"]): ?>
		<div style="text-align: center;"><img src="./images/ucp/ask-a-question2.png" title="Ask a Question" alt="Ask a Question" onclick="<?= $this->userauth->isUser() ? 'cpUpdater.toggleNewQuestion();' : 'showBox(\'login\')' ?>"/></div>
		<div id="cp-ask-question" style="display:none; text-align: center;"><? $this->load->view('question/_submit_question_form') ?></div>
	<? endif; ?>
	
	<? if($event_data['streaming'] && !$event_data["event_finished"]): ?>
		<div class="section">
			<span class="section-title">Current Question:</span>
		</div>
	
		<div id="current_question"></div>		  

		<table class="feed-reaction-panel">
			<tr>
				<td>
					<div id="video_container">
						<?= $stream_high ?>
					</div>
				</td>
				<td>
					<div id="user-reaction">
						Rate the credibility of each candidate's response for the current question.
						<? $this->load->view('user/_cp_user_reaction'); ?>
					</div>
					<div id="user-reaction-ajax"></div>
				</td>
			</tr>
		</table>
	<? elseif($event_data["event_finished"]): ?>
		<div class="section">
			<span class="section-title">Event Review:</span>
		</div>		  
		<table class="feed-reaction-panel">
			<tr>
				<td>
					<div id="video_container">
						Click play to watch the events entire footage or you can watch the answer to each question by clicking on the "answer" tab below each question.
						<?= $post_event_stream_high ?>
					</div>
				</td>
				<td>
					<div id="user-reaction">
						This shows aggregate user reaction for each candidate over the entire event.
						<table>
							<tr><th class="candidate">Candidate</th><th class="reaction" style="width">Reaction</th></tr>		
							<? $class = '' ?>
							<? foreach($candidates as $v): ?>
							<tr<?=$class?>>
								<td><?=$v['can_display_name']?></td>
								<td><div id="overall-reaction-<?=$v['can_id']?>"><?$this->load->view('user/_overallReaction', $v)?></div></td>
							</tr>
							<? $class = $class ? '' : ' class="alternate"' ?>
							<? endforeach; ?>
						</table>
					</div>
					<div id="user-reaction-ajax"></div>
				</td>
			</tr>
		</table>	
		<script type="text/javascript" charset="utf-8">
			<? foreach($candidates as $v): ?>
				new Ajax.Updater('overall-reaction-<?=$v["can_id"]?>', site_url + 'forums/overall_reaction/' + event_name + '/overall_reaction/<?=$v["can_id"]?>');
			<? endforeach; ?>
		</script>	
	<? endif; ?>
	
	<div class="section">
		<span class="section-title" id="question_title"><?= !$event_data["event_finished"] ? "Upcoming Questions" : "Answered Questions" ?> </span>
		<span style="float:right;padding-top:3px;cursor:pointer;">
			<span>Sort: </span>
			<? if(!$event_data["event_finished"]): ?>
				<span id="sort-link-pending-2" title="Upcoming" class="cp-sort-link-selected" onClick="cpUpdater.change_sort('pending')">Upcoming</span> | 
				<span id="sort-link-newest-2" title="Newest" class="cp-sort-link" onClick="cpUpdater.change_sort('newest')">Newest</span> | 
				<span id="sort-link-asked-2" title="Answered" class="cp-sort-link" onClick="cpUpdater.change_sort('asked')">Answered</span>&nbsp;&nbsp;
			<? else: ?>
				<span id="sort-link-pending-2" title="Unanswered" class="cp-sort-link" onClick="cpUpdater.change_sort('pending')">Unanswered</span> | 
				<span id="sort-link-asked-2" title="Answered" class="cp-sort-link-selected" onClick="cpUpdater.change_sort('asked')">Answered</span>&nbsp;&nbsp;			
			<? endif; ?>
		</span>
	</div>
	<div id="error_div"></div>
	<div id="upcoming_questions"></div>	
</div>

<div id="loading_reminder_div" class="loading_reminder">Loading...</div>
<script type="text/javascript" charset="utf-8">
	var my_loading_reminder = new Control.LoadingReminder('loading_reminder_div');
	
	function SwithDescription(){
		if($('event_description_full').getStyle('display') == 'none'){
			Effect.SlideUp('event_description', {duration: .5,   queue: 'end'});
			Effect.SlideDown('event_description_full', {  queue: 'end', afterFinish : function() { $('description_text').innerHTML = "Hide full description"; }});
			
		}else{
			Effect.SlideUp('event_description_full', {  queue: 'end'});
			Effect.SlideDown('event_description', { duration: .5,  queue: 'end', afterFinish : function(){ $('description_text').innerHTML = "See full description"; }});
			
		}
	}
	<? // If this is a past event then show answered questions by default ?>
	<? if($event_data["event_finished"]): ?>
		var upcoming_questions_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions/asked';
		var event_timing = 'past';
	<? else: ?>
		var upcoming_questions_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions/pending';
		var event_timing = 'not_past';
	<? endif; ?>
	var upcoming_questions_count_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions_count';
	
	Event.observe(window, 'load', cpUpdater.startLazyLoader);
</script>
<? $this->load->view('view_includes/footer.php', $data);?>