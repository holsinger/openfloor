<!-- 
#dependency all2.css
#dependency event.css
#dependency userWindow.css
dependency overall_reaction.css

#dependency cpUpdater.js
#dependency lazy_loader.js
#dependency loading_reminder.js
-->

<?
$cans = ''; foreach($candidates as $v) $cans .= "'{$v['can_id']}', "; $cans = substr($cans, 0, -2);
$data['js'] = "var event_name = '$event'; var cans = [$cans]; cpUpdater.cpUpdate();";

$data['left_nav'] = 'dashboard';
$data['sub_title'] = $event_data['event_name']; 
$this->load->view('view_includes/header.php', $data);
?>

<div id="overlay" onclick="hideBox()" style="display:none"></div>
<div id="hijax" style="display:none" class="ajax_box"></div>
<? if ($this->userauth->isAdmin()): ?>
<a class="link" onclick="cpUpdater.enableAJAX()">START</a>
<a class="link" onclick="cpUpdater.disableAJAX()">STOP</a>
<a class="link" onclick="cpUpdater.current_question_fade()">FADE</a>
<? endif; ?>

<div id="ucp">
	<div id="event_description"><b>Description:</b> <?=$event_data["event_desc_brief"]?>&nbsp;<a href="javascript: var none = SwithDescription('show');">See full description</a><br/></div>
	<div id="event_description_full" style="display:none;"><br /><b>Full Description:</b> <?=$event_data["event_desc"]?><br /><a href="javascript: var none = SwithDescription();">Hide Full Description</a><br/></div>
	<br />
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
				<br/><br/>
				<img src="./images/ucp/ask-a-question.jpg" onclick="<?= $this->userauth->isUser() ? 'new Effect.toggle(\'cp-ask-question\',\'blind\', {queue: \'end\'})' : 'showBox(\'login\')' ?>"/>
			</td>
		</tr>
	</table>
	<div id="cp-ask-question" style="display:none"><? $this->load->view('question/_submit_question_form') ?></div>
	<div class="section">
		<span class="section-title">Upcoming Questions</span>
		<span style="float:right;padding-top:3px;cursor:pointer;">
			<span>Sort: </span>
			<span id="sort-link-pending-2" class="cp-sort-link-selected" onClick="cpUpdater.change_sort('pending')">Upcoming</span> | 
			<span id="sort-link-newest-2" class="cp-sort-link" onClick="cpUpdater.change_sort('newest')">Newest</span> | 
			<span id="sort-link-asked-2" class="cp-sort-link" onClick="cpUpdater.change_sort('asked')">Answered</span>&nbsp;&nbsp;
		</span>
	</div>
	<div id="upcoming_questions"></div>	
</div>
<div id="loading_reminder_div" class="loading_reminder">Loading</div>
<script type="text/javascript" charset="utf-8">
	var my_loading_reminder = new Control.LoadingReminder('loading_reminder_div');
	
	function SwithDescription(action){
		if(action == 'show'){
			if($('event_description_full').getStyle('display') == 'none'){
				Effect.SlideDown('event_description_full', {  queue: 'end'});
			}
			
		}else{
			Effect.SlideUp('event_description_full', {  queue: 'end'});
		}
	}
	
</script>
<? $this->load->view('view_includes/footer.php', $data);?>