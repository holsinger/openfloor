<? 
$data['sub_title'] = "Add Classroom";
$this->load->view('view_layout/header.php', $data);
?>
<link rel="stylesheet" type="text/css" href="css/events.css" />
<div id="content_div">
	<div id="title">
		<div class="top"></div>
		<h1>Enroll Students</h1>
	</div>
	<div class="header">
		<h3>Students</h3>
	</div>
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open_multipart("classroom/enroll_stu/" . $classroom['classroom_id'], array('name'=>'my_form')); ?>
			<br /><br />
			<input type="button" name="back_but" value="Back to Class" id="back_but" onclick="window.location=site_url + 'classroom/view/<?=$classroom['classroom_id']?>';" class="button">
			<?= form_submit('','Enroll Selected Students','class="button"'); ?>
			
			<br /><br />
			<table>
				<tr>
					<td width="100%" align="right" colspan="4">
						<label><h3>Total: <?=count($users)?></h3></label>
					</td>
				</tr>
				<tr>
					<th>
						&nbsp;
					</th>
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
			<?php foreach ($users as $k => $user):?>
				<tr>
					<td>
						<?=form_checkbox('user_id[]', $user['user_id'], FALSE)?>
					</td>
					<td>
						<?=$user['display_name']?>
					</td>
					<td>
						<?=$user['user_email']?>
					</td>
					<td>
						<?=anchor('classroom/enroll_stu/' . $classroom['classroom_id'] . '/' . $user['user_id'], 'ENROLL')?>
					</td>
				</tr>
			<?php endforeach;?>
			</table>
			<br /><br />
			<input type="button" name="back_but" value="Back to Class" id="back_but" onclick="window.location=site_url + 'classroom/view/<?=$classroom['classroom_id']?>';" class="button">
			<?= form_submit('','Enroll Selected Students','class="button"'); ?>
		<?= form_close(); ?>
	</div>
	<div style="margin-top: 20px">
		<strong>
		POWERED BY OPENFLOOR TECHNOLOGY
		</strong>
	</div>
</div>
<? $this->load->view('view_layout/footer.php'); ?>