<? 
include("./fckeditor/fckeditor.php");
$data['sub_title'] = $page_title;
$this->load->view('view_includes/header.php', $data);
?>
<!--
	#dependency scal.js
	#dependency scal.css
-->
<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open_multipart(($user_id)?"event/manage_candidate/$event_id/$user_id":"event/manage_candidate/$event_id", array('name'=>'my_form')); ?>	
			<label>Speaker Display Name: *</label>
			<small>Write speaker's name as you want it displayed.</small><br />
			<input name="display_name" value="<?=$display_name?>" class="txt" size="48" maxlength="100">
			<br /><br />
			<label>Speaker Email Address: *</label>
			<small>Write the speaker's email address.</small><br />
			<input name="user_email" size="48" class="txt" value="<?=$user_email?>" />
			<br /><br />
			<label>Speaker Biography: *</label>
			<small>Write a bio of the the speaker.</small><br />
			<?
		     $oFCKeditor = new FCKeditor('bio') ;
		     $oFCKeditor->BasePath = 'fckeditor/' ;
		     $oFCKeditor->Height = '200';  $oFCKeditor->Width = '500';  $oFCKeditor->ToolbarSet = 'Basic';
			 $oFCKeditor->Value	 = $bio;
			 $oFCKeditor->Create() ;
			?>
			<br /><br />
			<label>Speaker Avatar</label>
			<small>Must be less then 1024 kb & 1024px768px (image will be resized)</small><br />
			<?= form_upload('user_avatar','$user_avatar','class="txt"') ?>
			<br /><br />
			<br /><br />
			<input type="button" onclick="window.location='event/create_event_two/<?=$event_id?>';" class="button" value="Cancel">
			<?= form_submit('',($can_id)?"Update Speaker":"Add Speaker",'class="button"'); ?>
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>
</div>
<script type="text/javascript" charset="utf-8">

</script>
<? $this->load->view('view_includes/footer.php'); ?>