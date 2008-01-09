<? 
//$data['top_banner_text'] = $contact_page_name;
$data['sub_title'] = $contact_page_name;
$this->load->view('view_layout/header.php',$data); 
$hidden = array('contact_type' => $contact_type);

?>
<div id="content_div">
    <h3></h3>
	<p>
		<?=$contact_page_desc?>
		<? if ($this->userauth->isSuperAdmin()) echo "<br>".anchor("admin/cms/".$contact_type, 'edit'); ?>
	</p>
	<?=$this->validation->error_string; ?>
	<?= form_open('contact/showForm/'.$contact_type, "", $hidden); ?>
		<br />
	    Name:&nbsp;<?=form_input(array('name' => 'sender_name', 'value' => $sender_name, 'size' => '20','class'=> 'txt'))?>
		<br />
		<br />
		Email:&nbsp;<?=form_input(array('name' => 'sender_email', 'value' => $sender_email, 'size' => '20','class'=> 'txt'))?>
		<br />
		<br />
	    <?=form_textarea(array('name' => 'feedback', 'value' => $feedback, 'id' => 'myform', 'cols' => '50', 'rows' => 15,'class'=> 'txt'))?>
		<br /><br />
		<?= form_submit('','Submit','class="button"'); ?>
		<?= form_close(); ?>
</div>
<? $this->load->view('view_layout/footer.php',$data); ?>