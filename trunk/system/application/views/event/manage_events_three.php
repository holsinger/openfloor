<? 
include("./fckeditor/fckeditor.php");
$data['sub_title'] = $page_title." Step Three";
$this->load->view('view_includes/header.php', $data);
?>
<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open("event/create_event_three/$event_id/$option", array('name'=>'my_form')); ?>
			<label>Low Bandwidth Stream:</label>
			<small>Contains the necessary code to insert the low bandwidth stream.</small><br />
			<textarea name="stream_low" rows="3" cols="48" class="txt"><?=$stream_low?></textarea>
			<br /><br />
			<label>High Bandwidth Stream:</label>
			<small>Contains the necessary code to insert the high bandwidth stream.</small><br />
			<textarea name="stream_high" rows="3" cols="48" class="txt"><?=$stream_high?></textarea>
			<br /><br />
			<label>Moderator Information:</label>
			<small>Write any information regarding how the event will be moderated.</small><br />
			<?
		     $oFCKeditor = new FCKeditor('moderator_info') ;
		     $oFCKeditor->BasePath = 'fckeditor/' ;
		     $oFCKeditor->Height = '150';  $oFCKeditor->Width = '500';  $oFCKeditor->ToolbarSet = 'Basic';
			 $oFCKeditor->Value	 = $moderator_info;
			 $oFCKeditor->Create() ;
			?>
			<br /><br />
			<label>Agenda:</label>
			<small>Write out the agenda.</small><br />
			<?
		     $oFCKeditor = new FCKeditor('agenda') ;
		     $oFCKeditor->BasePath = 'fckeditor/' ;
		     $oFCKeditor->Height = '150';  $oFCKeditor->Width = '500';  $oFCKeditor->ToolbarSet = 'Basic';
			 $oFCKeditor->Value	 = $agenda;
			 $oFCKeditor->Create() ;
			?>
			<br /><br />	
			<label>Rules: </label>
			<small>Write any rules that are required for this event.</small><br />
			<?
		     $oFCKeditor = new FCKeditor('rules') ;
		     $oFCKeditor->BasePath = 'fckeditor/' ;
		     $oFCKeditor->Height = '150';  $oFCKeditor->Width = '500';  $oFCKeditor->ToolbarSet = 'Basic';
			 $oFCKeditor->Value	 = $rules;
			 $oFCKeditor->Create() ;
			?>
			<br /><br />
			<label>Other Instructions: </label>
			<small>Write any additional instructions, if any.</small><br />
			<?
		     $oFCKeditor = new FCKeditor('other_instructions') ;
		     $oFCKeditor->BasePath = 'fckeditor/' ;
		     $oFCKeditor->Height = '150';  $oFCKeditor->Width = '500';  $oFCKeditor->ToolbarSet = 'Basic';
			 $oFCKeditor->Value	 = $other_instructions;
			 $oFCKeditor->Create() ;
			?>
			<br /><br />
			
			<? if($option == 'edit'): ?>
				<input type="button" name="cancel_but" value="Cancel" id="cancel_but" onclick="window.location=site_url+'event/admin_panel/<?=$event_id?>/3';" class="button">
				<?= form_submit('','Update Information','class="button"'); ?>
			<? else: ?>
				<input type="button" onclick="window.location='event/create_event_two/<?=$event_id?>';" class="button" value="Last Step">
				<?= form_submit('','Finish Event','class="button"'); ?>
			<? endif; ?>		
			
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>
</div>
<? $this->load->view('view_includes/footer.php'); ?>