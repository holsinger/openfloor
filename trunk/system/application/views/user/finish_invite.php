<? 
include("./fckeditor/fckeditor.php");
$data['sub_title'] = "Setup Account";
$this->load->view('view_includes/header.php', $data); ?>
<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open('user/invite_accept/'.$user_id.'/'.$timestamp, array('name'=>'my_form'), array('user_id' => $user_id)) ?>
			<label>User Name: *</label>
			<small>The username.</small><br />
			<input name="user_name" value="<?=$user_name?>" size="30" class="txt" maxlength="100">
			<br /><br />
			<label>Password:</label>
			<small>Both fields must match in order to set a password.</small><br />
			<input type="password" name="password_1" value="<?=$password_1?>" size="25" class="txt" maxlength="100"><br /><br />
			<input type="password" name="password_2" value="<?=$password_2?>" size="25" class="txt" maxlength="100">
			<br /><br />
			<br /><br />
			<?= form_submit('','Setup Account','class="button"'); ?>
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>

</div>
<? $this->load->view('view_includes/footer.php'); ?>