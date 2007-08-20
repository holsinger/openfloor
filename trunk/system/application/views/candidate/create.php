<?php
$can_name_attrs = array(				'name' => 'can_name', 
										'value' => $this->validation->can_name, 
										'class' => 'txt', 
										'maxlength' => 45);
						            
$can_display_name_attrs = array(		'name' => 'can_display_name',
										'value' => $this->validation->can_display_name,
										'class' => 'txt',
										'maxlength' => 100);
						            
$can_password_attrs = array(			'name' => 'can_password',
										'value' => $this->validation->can_password,
										'class' => 'txt',
										'maxlength' => 45);
						            
$can_password_confirm_attrs = array(	'name' => 'can_password_confirm', 
										'value' => $this->validation->can_password_confirm, 
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
?>

<? $this->load->view('view_includes/header.php');?>

<div id="content_div">
  <h2>Create a new candidate</h2>	
  	<div class='errorArea'><?=$error;?></div>
	
	<?= form_open('conventionnext/create/candidate')?>
	<?= form_format('Candidate Name: ', form_input($can_name_attrs)) ?>
	<?= form_format('Candidate Display Name: ', form_input($can_display_name_attrs)) ?>
	<?= form_format('Password: ', form_password($can_password_attrs)) ?>
	<?= form_format('Confirm Password: ', form_password($can_password_confirm_attrs)) ?>
	<?= form_format('Biography: ', form_textarea($can_bio_attrs)) ?>
	<?= form_format('Email: ', form_input($can_email_attrs)) ?>
	<?= form_hidden('submitted', 'true') ?>
	<p><?= form_submit(null, 'Add Candidate', 'class="button"') ?></p>
	<?= form_close() ?>
</div>

<? $this->load->view('view_includes/footer.php'); ?>