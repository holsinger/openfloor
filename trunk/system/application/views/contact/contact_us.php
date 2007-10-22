
<? $this->load->view('view_includes/header.php',$data); ?>
<?php
$attributes = array('name' => 'feedback', 'id' => 'myform', 'cols' => '50', 'rows' => 15);
$hidden = array('contact_type' => $contact_type);
?>
<div id="content_div">
    <h3><?=$contact_page_name?></h3>
	<p>
		<?=$contact_page_desc?>
		<? if ($this->userauth->isSuperAdmin()) echo "<br>".anchor("admin/cms/".$contact_type, 'edit'); ?>
	</p>
	
	<?= form_open('contact/send', "", $hidden); ?>
		<br />
	    <?=form_textarea($attributes)?>
		<br /><br />
		<?= form_submit('','Submit','class="button"'); ?>
		<?= form_close(); ?>
</div>
<? $this->load->view('view_includes/footer.php',$data); ?>