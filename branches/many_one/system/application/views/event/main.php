<?
$cans = ''; 
foreach($candidates as $v){
	$cans .= "'{$v['user_id']}', "; 
	$cans = substr($cans, 0, -2);
} 

$data['js'] = "var event_name = '$event'; var cans = [$cans];";
$data['left_nav'] = 'dashboard';
$data['sub_title'] = $event_data['event_name']; 
$this->load->view('view_layout/header.php', $data);
?>
<!-- 
#dependency event.css
#dependency userWindow.css
dependency overall_reaction.css

#dependency cpUpdater.js
#dependency lazy_loader.js
#dependency loading_reminder.js
-->
<? if ($this->userauth->isEventAdmin($event_data['event_id'])): ?>
	<div><b>Administration:</b></div> 
	<? if(!$event_data['streaming'] && !$event_data["event_finished"]): ?>
		<input value="Start Streaming" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/stream',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not stream event.') } });">
	<? elseif(!$event_data["event_finished"]): ?>
		<input value="Stop Streaming" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/no_stream',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not stop streaming event.') } });">
		<input value="Finish Event" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/finish',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not end the event.') } });">
		<input value="Advance Queue" class="button" type="button" onclick="new Ajax.Request(site_url+'forums/next_question/<?=$event_data['event_id']?>',  { onSuccess: function(transport){    }, onFailure: function(){ alert('Could not change question.') } });">
		<input value="Next Question" class="button" type="button" onclick="new Ajax.Request(site_url+'forums/next_question/<?=$event_data['event_id']?>',  { onSuccess: function(transport){    }, onFailure: function(){ alert('Could not change question.') } });">
	<? else: ?>
		<input value="Unfinish Event" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/no_finish',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not unfinish event.') } });">
	<? endif; ?>
	<? if(!$event_data['event_finished']): ?>
		<input value="Admin Panel" class="button" type="button" onclick="window.location=site_url+'event/admin_panel/<?=$event_data['event_id']?>'">
	<? endif; ?>
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
		<div style="text-align: center; margin-bottom: 4px;"><img src="./images/many_one/button_ask_question.png" title="Ask a Question" alt="Ask a Question" onclick="<?= $this->userauth->isUser() ? 'cpUpdater.toggleNewQuestion();' : $this->config->item('m1_url').'/login/' ?>"/></div>
		<div id="cp-ask-question" style="display:none; text-align: center; margin-bottom: 5px;">
			<div style="width: 500px; text-align: left; margin-left: 278px; background-color: #F2F2F2; padding: 5px;">
			<? $this->load->view('question/_submit_question_form') ?>
			</div>
		</div>
	<? endif; ?>
	
	<? if($event_data['streaming'] && !$event_data["event_finished"]): ?>
		<div class="section">
			<h3>Current Question</h3>
		</div>
	
		<div id="current_question"></div>		  

		<table class="feed-reaction-panel">
			<tr>
				<td style="width: 50%">
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
			<h3>Event Review:</h3>
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
							<tr>
								<th class="candidate">&nbsp;&nbsp;Candidate</th>
								<th class="reaction">&nbsp;&nbsp;Reaction</th>
							</tr>		
							<? $class = '' ?>
							<? foreach($candidates as $v): ?>
								<tr <?=$class?>>
									<td><?=$v['display_name']?></td>
									<td><div id="overall-reaction-<?=$v['user_id']?>"><?$this->load->view('user/_overallReaction', $v)?></div></td>
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
				new Ajax.Updater('overall-reaction-<?=$v["user_id"]?>', site_url + 'forums/overall_reaction/' + event_name + '/overall_reaction/<?=$v["user_id"]?>');
			<? endforeach; ?>
		</script>	
	<? endif; ?>
	<br /><br />
	<div class="section">
		<h3 id="question_title"><?= !$event_data["event_finished"] ? "Upcoming Questions" : "Answered Questions" ?></h3>
		<!-- <div class="section-title" id="question_title" style=" "><?= !$event_data["event_finished"] ? "Upcoming Questions" : "Answered Questions" ?> </div> -->
		<span style="float:right;padding-top:3px;cursor:pointer; margin-top: -20px">
			<span>Show: </span>
			<? if(!$event_data["event_finished"]): ?>
				<span id="sort-link-pending" title="Upcoming" class="cp-sort-link-selected" onClick="cpUpdater.change_sort('pending')">Upcoming</span> | 
				<span id="sort-link-newest" title="Newest" class="cp-sort-link" onClick="cpUpdater.change_sort('newest')">Newest</span> | 
				<span id="sort-link-asked" title="Answered" class="cp-sort-link" onClick="cpUpdater.change_sort('asked')">Answered</span> | 
				<span id="sort-link-deleted" title="Deleted" class="cp-sort-link" onClick="cpUpdater.change_sort('deleted')">Deleted</span>&nbsp;&nbsp;
			<? else: ?>
				<span id="sort-link-pending" title="Unanswered" class="cp-sort-link" onClick="cpUpdater.change_sort('pending')">Unanswered</span> | 
				<span id="sort-link-asked" title="Answered" class="cp-sort-link-selected" onClick="cpUpdater.change_sort('asked')">Answered</span> | 		
				<span id="sort-link-deleted" title="Deleted" class="cp-sort-link" onClick="cpUpdater.change_sort('deleted')">Deleted</span>&nbsp;&nbsp;			
			<? endif; ?>
		</span>
	</div>
	<div id="error_div"></div>
	<div id="upcoming_questions"></div>	
	<div style="margin-top: 20px; text-align: center;">
			<a href="http://www.openfloortech.com"><img src="images/logos/powered_by.png" border="0" /></a>
	</div>
</div>

<div id="loading_reminder_div" class="loading_reminder">&nbsp;<img style="padding-top: 2px;" src="images/many_one/ajax-loader.gif"></div>
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
	// If this is a past event then show answered questions by default
	<? if($event_data["event_finished"]): ?>
		var upcoming_questions_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions/asked';
		var event_timing = 'past';
	<? else: ?>
		var upcoming_questions_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions/pending';
		var event_timing = 'not_past';
	<? endif; ?>
	var upcoming_questions_count_url = site_url + 'forums/cp/' + event_name + '/upcoming_questions_count';
	
	Event.observe(window, 'load', cpUpdater.startLazyLoader);
	Event.observe(window, 'load', StartUpdater);
	function StartUpdater(){
		<? if($event_data['streaming']): ?>
			cpUpdater.cpUpdate(true);
		<? else: ?>
			cpUpdater.cpUpdate(false);
		<? endif; ?>
		
	}
</script>
<? $this->load->view('view_layout/footer.php', $data);?>