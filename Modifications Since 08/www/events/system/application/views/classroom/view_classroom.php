<? 
$data['sub_title'] = "Add Classroom";
$this->load->view('view_layout/header.php', $data);
?>
<link rel="stylesheet" type="text/css" href="css/events.css" />
<div id="content_div">
	<div id="title">
		<div class="top"></div>
		<h1>View Classroom</h1>
	</div>
	<div class="header">
		<h3>Classroom</h3>
	</div>
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open_multipart("classroom/delete/" . $classroom['classroom_id'], array('name'=>'my_form')); ?>
			<br /><br />
			<label>Class Name:</label><br>
			<label>
				<?=$classroom['name']?>
			</label>
			<br /><br />
			<label>Description:</label><br>
			<label><?=$classroom['description']?></label>
			<br /><br />
			<table>
				<tr>
					<td width="100%" align="right" colspan="3">
						<label><h3>Total: <?=count($students)?></h3></label>
					</td>
				</tr>
				<tr>
					<th>
						Name
					</th>
					<th>
						Email
					</th>
					<th>
						Option
					</th>
				</tr>
			<?php foreach ($students as $k => $student):?>
				<tr>
					<td>
						<?=$student['display_name']?>
					</td>
					<td>
						<?=$student['user_email']?>
					</td>
					<td>
						<?=anchor('classroom/delete_stu/' . $classroom['classroom_id'] . '/' . $student['user_id'], 'DELETE')?>
					</td>
				</tr>
			<?php endforeach;?>
			</table>
			<br /><br />
			<input type="button" name="back_but" value="Back to Home" id="back_but" onclick="window.location=site_url;" class="button">
			<input type="button" name="back_but" value="Manage Students" id="back_but" onclick="window.location=site_url + 'classroom/enroll_stu/<?=$classroom['classroom_id']?>';" class="button">
			<?= form_submit('','Delete Classroom','class="button"'); ?>
		<?= form_close(); ?>
	</div>
	<div style="margin-top: 20px">
		<strong>
		POWERED BY OPENFLOOR TECHNOLOGY
		</strong>
	</div>
</div>
<? $this->load->view('view_layout/footer.php'); ?>