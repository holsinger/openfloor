<? 
include("./fckeditor/fckeditor.php");
$data['sub_title'] = "Edit User";
$this->load->view('view_includes/header.php', $data); ?>
<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open_multipart('user/edit_user/'.$user_id, array('name'=>'my_form') , array("user_id" => $user_id)) ?>
			<label>User Name: *</label>
			<small>The username.</small><br />
			<input name="user_name" value="<?=$user_name?>" size="30" class="txt" maxlength="100">
			<br /><br />
			<label>Display Name: *</label>
			<small>The full name.</small><br />
			<input name="display_name" value="<?=$display_name?>" size="40" class="txt" maxlength="100">
			<br /><br />
			<label>Email Address: *</label>
			<small>Current Email Address.</small><br />
			<input name="user_email" value="<?=$user_email?>" size="40" class="txt" maxlength="100">
			<br /><br />
			<label>Password:</label>
			<small>Enter matching password to reset.  If both fields are left blank then the password will remain the same.</small><br />
			<input type="password" name="password_1" value="<?=$password_1?>" size="25" class="txt" maxlength="100"><br /><br />
			<input type="password" name="password_2" value="<?=$password_2?>" size="25" class="txt" maxlength="100">
			<br /><br />
			<label>Avatar</label>
			<small>Must be less then 1024 kb & 1024px768px (image will be resized)</small><br />
			<?= form_upload('userfile', '','class="txt"') ?>
			<br /><br />
			<label>Bio:</label>
			<small>Write a biography.</small><br />
			<?
		     $oFCKeditor = new FCKeditor('bio') ;
		     $oFCKeditor->BasePath = 'fckeditor/' ;
		     $oFCKeditor->Height = '180';  $oFCKeditor->Width = '500';  $oFCKeditor->ToolbarSet = 'Basic';
			 $oFCKeditor->Value	 = $bio;
			 $oFCKeditor->Create() ;
			?>
			<br /><br />
			<?= form_submit('','Update User','class="button"'); ?>
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>

</div>
<? $this->load->view('view_includes/footer.php'); ?>