<?php
$data['left_nav'] = 'event';
$display_titles = array('event_desc_brief' => 'Brief Description',
						'event_desc' => 'Full Description',
						'event_date' => 'Event Date',
						'location' => 'Event Location',
						'moderator_info' => 'Moderator Info',
						'agenda' => 'Agenda',
						'rules' => 'Rules',
						'other_instructions' => 'Other Instructions');
?>

<? $this->load->view('view_includes/header.php', $data);?>

<div id="content_div">
  <h2>Event Details</h2>
	<span><? $img = !empty($event['event_avatar']) ? "<img src=\"./avatars/{$event['event_avatar']}\">" : ''; echo $img; ?></span>
	<span><h3><?= $event['event_name'] ?></h3></span>
	<? foreach($display_titles as $k => $v): ?>
  	<? 	if(!empty($event[$k])): ?>
	<p><?= "<strong>$v:</strong> {$event[$k]}" ?></p>
	<? 	endif; ?>
	<? endforeach; ?>
	
	<? if($this->userauth->isAdmin()) echo anchor("event/edit_event/{$event['event_id']}", 'edit') ?>	
</div>

<? $this->load->view('view_includes/footer.php'); ?>