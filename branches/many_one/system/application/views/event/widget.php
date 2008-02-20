<?
$cans = ''; 
foreach($candidates as $v){
	$cans .= "'{$v['user_id']}', "; 
} 
$cans = substr($cans, 0, -2);
$data['js'] = "var event_name = '$event'; var event_id = {$event_data['event_id']}; var user_id = $user_id; var cans = [$cans];";
$data['left_nav'] = 'dashboard';
$data['sub_title'] = $event_data['event_name']; 
$this->load->view('view_layout/widget_header.php', $data);
?>
<!-- 
#dependency event_widget.css
#dependency userWindow.css
dependency overall_reaction.css

#dependency cpUpdater.js
#dependency lazy_loader.js
#dependency loading_reminder.js
-->
<div id="overlay" onclick="hideBox()" style="display:none"></div>
<div id="hijax" style="display:none"></div>
<div id='top_lock'>
<h2 class='widget_section'><?=$event_data['event_name'];?></h2>
	<?/*?><div id="video_container">
		<?= $stream_high ?>
	</div>
	<? if(!$event_data["event_finished"] && !$is_respondent): ?>
		<div style="text-align: center; margin-bottom: 4px;"><img src="./images/many_one/button_ask_question.png" title="Ask a Question" alt="Ask a Question" onclick="<?= $this->userauth->isUser() ? 'cpUpdater.toggleNewQuestion();' : $this->config->item('m1_url').'/login/' ?>"/></div>
	<? endif; ?>*/?>

	<div id="cp-ask-question" style="display:none; text-align: center; margin-bottom: 5px;">
		<div style="width: 490px; text-align: left; background-color: #F2F2F2; padding: 5px;">
			<? $this->load->view('question/_submit_question_form') ?>
		</div>
	</div>



	<? if ($this->userauth->isEventAdmin($event_data['event_id'])): ?>
	
		<div class='widget_section' onClick="Fold('admin','admin_tab');"> <span id="admin_tab">-</span> Administration: </div>
		<div id='admin'> 
		<? if(!$event_data['streaming'] && !$event_data["event_finished"]): ?>
			<input value="Start Event" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/stream',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not stream event.') } });">
		<? elseif(!$event_data["event_finished"]): ?>
			<input value="Stop Event" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/no_stream',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not stop streaming event.') } });">
			<input value="Close Event" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/finish',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not end the event.') } });"><br/>
			<input class="button" type="button" onclick="window.open('http://prelive.ustream.tv/broadcaster/IBo6cdjuzGo0x.6P6qk6b69fwm3Ftefb', '_blank', 'width=700,height=430,scrollbars=no,status=no,resizable=yes,screenx=20,screeny=20');" style="background: rgb(69, 110, 189) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" value="Launch Video Broadcaster"/><br/>
			<!-- this only applies to a multi respondent event -->
			<input value="Advance Queue" class="button" type="button" onclick="new Ajax.Request(site_url+'forums/move_queue/forward/<?=$event_data['event_id']?>',  { onSuccess: function(transport){    }, onFailure: function(){ alert('Could not change question.') } });"> (Mutli-Respondent Events Only)<br />
			<input value="Goto The Next Question" class="button" type="button" onclick="new Ajax.Request(site_url+'forums/next_question/<?=$event_data['event_id']?>',  { onSuccess: function(transport){    }, onFailure: function(){ alert('Could not change question.') } });">
		
		<? else: ?>
			<input value="Reopen Event" class="button" type="button" onclick="new Ajax.Request(site_url+'event/change_event_status_ajax/<?=$event_data['event_id']?>/no_finish',  { onSuccess: function(transport){ if(transport.responseText){ window.location = site_url+'forums/cp/<?=url_title($event_data['event_name'])?>'; }  }, onFailure: function(){ alert('Could not unfinish event.') } });">
		<? endif; ?>
		<? if(!$event_data['event_finished']): ?>
			<br />
			<input value="Edit Event" class="button" type="button" onclick="window.location=site_url+'event/admin_panel/<?=$event_data['event_id']?>'">
		<? endif; ?>
		</div><!-- end admin-- >
	<? endif; ?>
	<div class='widget_section' onClick="Fold('desc_sect','desc_tab');"> <span id='desc_tab'>-</span> Description:</div>
	<div id='desc_sect'>
		<? if(!$event_data['streaming']): ?>
			<div><b>When:</b> <?=date("F j, Y, g:i a", strtotime($event_data['event_date']))?></div>
			<div><b>Where:</b> <?=$event_data["location"]?><br /><br /></div>
		<? endif; ?> 
		<div id="event_description">
			<?=$event_data["event_desc_brief"]?><br />
		</div>
		<div id="event_description_full" style="display:none; font-weight: normal;">
			<br />Candidates: <?=$event_data['participants']?>
			<br /><?=$event_data["event_desc"]?>
		</div>
		<div><a href="javascript: var none = SwithDescription('show');"  title="See Full Description"><span id="description_text">See full description</span></a><br/></div>
	</div>
</div><!-- end top lock -->	
<div id="ucp">	
	<? if($event_data['streaming'] && !$event_data["event_finished"]): ?>
		
		<div class="widget_section" onClick="Fold('cq_sect','cq_tab');"><span id='cq_tab'>-</span> Current Question</div>
		<div id='cq_sect'>
			<div id="current_question">loading...</div>
			<br/>
		</div>
		<div class="widget_section" onClick="Fold('af_sect','af_tab');"><span id='af_tab'>-</span> Answer Feedback</div>
		<div id='af_sect'>
			<? if($is_respondent): ?>
				<div class="feed-reaction-panel">
					<div>
						<span style="float:left;">
							<div id="respondent_div">
								loading...
							</div>
						</span>
						<span style="float:right;">
							<div>
								The following shows the order of the respondents and which respondent is currently on tap to respond.
								<? $this->load->view('event/respondent_reaction'); ?>
							</div>
						</span>
						<span style="clear:both;" />
					</div>
				</div>
			<? else: ?>
				<div class="feed-reaction-panel">
					<div>
						<?/*?><span style="width: 50%">
							<div id="video_container">
								<?= $stream_high ?>
							</div>
						</span>*/?>
						<span>
							<div id="user-reaction">
								Rate the credibility of each candidate's response for the current question.
								<? $this->load->view('user/_cp_user_reaction'); ?>
							</div>
						</span>
					</div>
				</div>
			<? endif; ?>
		</div>	
		<div class="widget_section" >&nbsp; Dynamic Question Queue</div>
		<div id="body_lock">
		
	<? elseif($event_data["event_finished"]): ?>
		<div class="section">
			<h3>Event Review:</h3>
		</div>		  
		<div class="feed-reaction-panel">
			<div>
				<span>
					<div id="video_container">
						Click play to watch the events entire footage or you can watch the answer to each question by clicking on the "answer" tab below each question.
						<?= $post_event_stream_high ?>
					</div>
				</span>
				<span>
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
				</span>
			</div>
		</div>	
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
	</div> <!-- end body_lock -->
	<div id='bottom_lock' style="margin-top: 20px; text-align: center;">
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
	function Fold(div,tab){
		if($(div).getStyle('display') == 'none'){
			Effect.SlideDown(div, {  queue: 'end', afterFinish : function() { $(tab).innerHTML = "-"; }});
			
		}else{
			Effect.SlideUp(div, {  queue: 'end', afterFinish : function(){ $(tab).innerHTML = "+"; }});
			
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
	cpUpdater.is_respondent = <?=($is_respondent)?"true":"false"?>;
	
	Event.observe(window, 'load', cpUpdater.startLazyLoader);
	Event.observe(window, 'load', StartUpdater);
	function StartUpdater(){
		<? if($event_data['streaming']): ?>
			cpUpdater.cpUpdate(true);
		<? else: ?>
			cpUpdater.cpUpdate(false);
		<? endif; ?>
		
	}
	/*Event.observe(window, 'load', ResizeWidget);
	function ResizeWidget(){
		var resize_height = document.viewport.getHeight() - ($('top_lock').getHeight()+$('cq_sect').getHeight()+$('bottom_lock').getHeight());
		if (resize_height<250) resize_height = 250;
		$('body_lock').style.height = resize_height+'px';	
	}*/
</script>
<? $this->load->view('view_layout/widget_footer.php', $data);?>