<?php
// $can_name_attrs = array(				'name' => 'can_name', 
// 										'value' => $this->validation->can_name, 
// 										'class' => 'txt', 
// 										'maxlength' => 45);
						            
$can_display_name_attrs = array(		'name' => 'can_display_name',
										'value' => $this->validation->can_display_name,
										'class' => 'txt',
										'maxlength' => 100);
						            
$can_password_attrs = array(			'name' => 'can_password',
										'value' => '',
										'class' => 'txt',
										'maxlength' => 45);
						            
$can_password_confirm_attrs = array(	'name' => 'can_password_confirm', 
										'value' => '', 
										'class' => 'txt', 
										'maxlength' => 45);
                                    
$can_bio_attrs = array(					'name' => 'can_bio',
										'value' => $this->validation->can_bio,
										'class' => 'txt',
										'rows' => '3',
						            	'cols' => '48');
                                    
$can_email_attrs = array(				'name' => 'can_email',
										'value' => $this->validation->can_email,
										'class' => 'txt',
										'maxlength' => 45);
										
if($action == 'create') $submit_text = "Add Candidate";
else 					$submit_text = "Edit Candidate";
?>

<? $this->load->view('view_includes/header.php');?>

<div id="content_div">
	<? if($action == 'create'): ?>
  <h2>Create a New Candidate</h2>
	<? else: ?>
	<h2>Edit Candidate: <?=$_POST['can_display_name']?></h2>
	<? endif; ?>
	
  	<div class='errorArea'><?=$error;?></div>
	
	<? if($action == 'create'): ?>
  	<?= form_open('conventionnext/create/candidate') ?>
	<? else: ?>
		<?= form_open('conventionnext/edit/candidate/' . url_title($_POST['can_display_name']), null, array('can_id' => $_POST['can_id'])) ?>
	<? endif; ?>
	
	
	<?//= form_format('Candidate Name: ', form_input($can_name_attrs)) ?>
	<?= form_format('Candidate Display Name: ', form_input($can_display_name_attrs)) ?>
	<?= form_format('Password: ', form_password($can_password_attrs)) ?>
	<?= form_format('Confirm Password: ', form_password($can_password_confirm_attrs)) ?>
	<?= form_format('Biography: ', form_textarea($can_bio_attrs)) ?>
	<?= form_format('Email: ', form_input($can_email_attrs)) ?>
	<?= form_hidden('submitted', 'true') ?>
	<p><?= form_submit(null, $submit_text, 'class="button"') ?></p>
	<?= form_close() ?>
</div>

<? $this->load->view('view_includes/footer.php'); ?>