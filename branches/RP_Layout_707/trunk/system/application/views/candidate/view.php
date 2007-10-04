<?php
$display_titles = array(//'can_name' => 'Profile Name',
						'can_display_name' => 'Display Name',
						'can_bio' => 'Biography'/*,
						'can_email' => 'Email Address'*/);
?>

<? $this->load->view('view_includes/header.php');?>

<div id="content_div">
  <h2>Candidate Profile</h2>
	<? foreach($display_titles as $k => $v): ?>
  	<? 	if(!empty($candidate[$k])): ?>
	<p><?= "<strong>$v:</strong> {$candidate[$k]}" ?></p>
	<? 	endif; ?>
	<? endforeach; ?>
	
	<? if($this->userauth->isAdmin()) echo anchor('conventionnext/edit/candidate/' . url_title($candidate['can_display_name']), 'edit') ?>	
</div>

<? $this->load->view('view_includes/footer.php'); ?>