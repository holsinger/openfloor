<? 
$data['sub_title'] = "Add Classroom";
$this->load->view('view_layout/header.php', $data);
?>

<link rel="stylesheet" type="text/css" href="css/events.css" />
<div id="content_div">
	<div id="title">
		<div class="top"></div>
		<h1>Create Classroom</h1>
	</div>
	<div class="header">
		<h3>Classroom</h3>
	</div>
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open_multipart("classroom/add/", array('name'=>'my_form')); ?>
			<br /><br />
			<label>Class Name: *</label>
			<small>Write the name of the class.</small><br />
			<input name="class_name" value="" size="45" class="txt" maxlength="100"/>
			<br /><br />
			<label>Description:</label>
			<small>Write a description of the classroom.</small><br />
			<textarea name="description" rows="3" cols="48" class="txt"></textarea>
			<br /><br />
			<input type="button" name="back_but" value="Back to Home" id="back_but" onclick="window.location=site_url;" class="button">
			<?= form_submit('','Add Classroom','class="button"'); ?>
		<?= form_close(); ?>
	</div>
	<div style="margin-top: 20px">
		<strong>
		POWERED BY OPENFLOOR TECHNOLOGY
		</strong>
	</div>
</div>
<? $this->load->view('view_layout/footer.php'); ?>