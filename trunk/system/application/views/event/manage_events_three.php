<? 
include("./fckeditor/fckeditor.php");
$setup['sub_title'] = $page_title;
$setup['head_include'] = array("plaxo");
$this->load->view('view_layout/header.php', $setup);
?>
<!--
	#dependency events.css
	#dependency inline_label.js
	#dependency password_strength_validator.js
-->

<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open("event/create_event_three/$event_id/$option", array('name'=>'my_form')); ?>
			<h3>Event Access</h3>
			
			<input type="radio" name="access_type" value="public" id="access_type" onclick="enable_disable();" <?=($access_type == "public")?"checked":""?>>&nbsp;<label style="display: inline;">Public</label>
			<div class="form_indent"><small><?=$public_disclaimer?></small></div>
			
			<input type="radio" name="access_type" value="private" id="access_type" onclick="enable_disable();" <?=($access_type == "private")?"checked":""?>>&nbsp;<label style="display: inline;">Private</label>
			<div class="form_indent">
				<?=form_checkbox('password_protect', '1', $password_protect, 'id = "password_protect"  onclick="enable_disable();"')?>&nbsp;Password Protect<br />
				<div class="form_indent">
					<span style="float: left;">
						<input type="password" name="password_protect_password" value="<?=$password_protect_password?>" id="password_protect_password" class="txt">
					</span>
					<span style="float: left; margin-left: 10px; vertical-align: middle; line-height: 25px">
						Strength&nbsp;
					</span>
					<span style="float: left">
						<div style="border: 1px solid gray; width: 100px; overflow: hidden"> 
							<div id="progressBar" style="font-size: 1px; height: 20px; width: 0px; margin: 1px;"></div>
						</div>
					</span>
					<br /><br />
				</div>
				<br />
				
				<? if($option != "edit"): ?>
					<?=form_checkbox('email_invite', '1', $email_invite, 'id = "email_invite"  onclick="enable_disable();"')?>&nbsp;Send Email Invite<br />
					<div class="form_indent">
						<textarea id="recipient_list" name="recipients" class="txt"><?=$recipients?></textarea><br />
						<a href="#" onclick="showPlaxoABChooser('recipient_list', site_url+'event/plaxo_callback'); return false"><img src="http://www.plaxo.com/images/abc/buttons/add_button.gif" alt="Add from my address book" /></a>
					</div>
				<? endif; ?>
				
				<?=form_checkbox('domain_limit', '1', $domain_limit, 'id = "domain_limit"  onclick="enable_disable();"')?>&nbsp;Limit Access to Email Domain<br />
				<div class="form_indent"><input type="text" name="domain_limit_name" value="<?=$domain_limit_name?>" id="domain_limit_name" class="txt"></div>
				<small><br /><?=$private_disclaimer?></small>
			</div>
			<br /><br />
			
			<? if($option == 'edit'): ?>
				<input type="button" name="cancel_but" value="Cancel" id="cancel_but" onclick="window.location=site_url+'event/admin_panel/<?=$event_id?>/3';" class="button">
				<?= form_submit('','Update Information','class="button"'); ?>
			<? else: ?>
				<input type="button" onclick="window.location='event/create_event_two/<?=$event_id?>';" class="button" value="Previous Step">
				<?= form_submit('','Finish Event','class="button"'); ?>
			<? endif; ?>		
			
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>
</div>
<script>
	new Form.InlineLabel('domain_limit_name', "Domain Name");
	new Form.InlineLabel('password_protect_password', "********");
	new Control.PasswordStrengthValidator('password_protect_password', 'progressBar', { default_password : "********" });
	// Enable Disable Function
	function enable_disable(){
		if($F('access_type') == 'public'){
			$('password_protect').disable();
			$('email_invite').disable();
			$('domain_limit').disable();
			$('password_protect_password').disable();
			$('recipient_list').disable();
			$('domain_limit_name').disable();
		}else{
			$('password_protect').enable();
			if($('password_protect').checked){
				$('password_protect_password').enable();
			}else{
				$('password_protect_password').disable();
			}
			$('email_invite').enable();
			if($('email_invite').checked){
				$('recipient_list').enable();
			}else{
				$('recipient_list').disable();
			}
			$('domain_limit').enable();
			if($('domain_limit').checked){
				$('domain_limit_name').enable();
			}else{
				$('domain_limit_name').disable();
			}
		}
	}
	enable_disable();
</script>
<? $this->load->view('view_layout/footer.php'); ?>