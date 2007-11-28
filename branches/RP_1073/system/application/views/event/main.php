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
<div id="overlay" onclick="hideBox()" style="display:none"></div>
<div id="hijax" style="display:none" class="ajax_box"></div>
<? if ($this->userauth->isAdmin()): ?>
<a class="link" onclick="cpUpdater.enableAJAX()">START</a>
<a class="link" onclick="cpUpdater.disableAJAX()">STOP</a>
<a class="link" onclick="cpUpdater.current_question_fade()">FADE</a>
<? endif; ?>

<div id="ucp">
	<? if(!$event_data['streaming']): ?>
		<div><b>When:</b> <?=date("F j, Y, g:i a", strtotime($event_data['event_date']))?></div>
		<div><b>Where:</b> <?=$event_data["location"]?><br /><br /></div>
	<? endif; ?>
	<div><b>Description:</b></div> 
	<div id="event_description"><?=$event_data["event_desc_brief"]?><br /></div>
	<div id="event_description_full" style="display:none; font-weight: normal;"><br /><?=$event_data["event_desc"]?></div>
	<div><br/><a href="javascript: var none = SwithDescription('show');"  title="See Full Description"><span id="description_text">See full description</span></a><br/></div>
	<br />
	<div style="text-align: center;"><img src="./images/ucp/ask-a-question2.png" title="Ask a Question" alt="Ask a Question" onclick="<?= $this->userauth->isUser() ? 'new Effect.toggle(\'cp-ask-question\',\'blind\', {queue: \'end\'})' : 'showBox(\'login\')' ?>"/></div>
	<div id="cp-ask-question" style="display:none; text-align: center;"><? $this->load->view('question/_submit_question_form') ?></div>
	<? if($event_data['streaming']): ?>
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
	<? endif; ?>
	
	<div class="section">
		<span class="section-title" id="question_title"><?= strtotime($event_data['event_date']) >= strtotime(date('Y-m-d')) || $event_data['streaming'] ? "Upcoming Questions" : "Answered Questions" ?> </span>
		<span style="float:right;padding-top:3px;cursor:pointer;">
			<span>Sort: </span>
			<? if(strtotime($event_data['event_date']) >= strtotime(date('Y-m-d')) || $event_data['streaming']): ?>
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
	<? if(strtotime($event_data['event_date']) < strtotime(date('Y-m-d')) && !$event_data['streaming']): ?>
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