<?php
$data['red_head'] = $event_type.'s';
$data['tabs'] = $event_type;
$data['tab_submit_question'] = 'active';
$data['event_url'] = $event_url;
$data['left_nav'] = 'event';
?>

<? $this->load->view('view_layout/header.php',$data); ?>

<div id="content_div">
	<h3>Submit a <?=ucfirst($event_type);?></h3>
	<? $this->load->view('question/_submit_question_form') ?>
</div>

<? $this->load->view('view_layout/footer.php'); ?>