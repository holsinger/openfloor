<!-- 
#dependency all2.css
#dependency event.css
#dependency userWindow.css
dependency overall_reaction.css

#dependency cpUpdater.js
-->

<?
$cans = ''; foreach($candidates as $v) $cans .= "'{$v['can_id']}', "; $cans = substr($cans, 0, -2);
$data['js'] = "var event_name = '$event'; var cans = [$cans]; cpUpdater.cpUpdate();";

$data['sub_title'] = "Event"; // what do we want to call this?
$this->load->view('view_includes/header.php', $data);
?>

<div id="overlay" onclick="hideBox()" style="display:none"></div>
<div id="hijax" style="display:none" class="ajax_box"></div>
<? if ($this->userauth->isAdmin()): ?>
<a class="link" onclick="cpUpdater.enableAJAX()">START</a>
<a class="link" onclick="cpUpdater.disableAJAX()">STOP</a>
<? endif; ?>

<div id="ucp">
	<div class="section">
		<span class="section-title">Current Question:</span>
	</div>

	<div id="current_question">
	<? $this->load->view('user/cp_current_question'); ?>
	</div>		  

	<table class="feed-reaction-panel">
		<tr>
			<td>
				<div class="section">
					<span class="section-title">Live Video Feed:</span>
				</div>
				<div id="video_container">
					<?= $stream_high ?>
				</div>
			</td>
			<td>
				<div class="section">
					<span class="section-title">Participant Reaction:</span>
				</div>
				<div id="user-reaction">
					Rate the credibility of each candidate's response for each question.
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
			<span id="sort-link-pending" class="cp-sort-link-selected" onClick="cpUpdater.change_sort('pending')">Upcoming</span> | 
			<span id="sort-link-newest" class="cp-sort-link" onClick="cpUpdater.change_sort('newest')">Newest</span> | 
			<span id="sort-link-asked" class="cp-sort-link" onClick="cpUpdater.change_sort('asked')">Asked</span>&nbsp;&nbsp;
		</span>
	</div>
	<div id="upcoming_questions">		
		<? $this->load->view('user/cp_upcoming_questions') ?>
	</div>	
</div>

<? $this->load->view('view_includes/footer.php', $data);?>