<? 
$data['sub_title'] = $page_title." Step Two";
$this->load->view('view_includes/header.php', $data);
?>
<div id="content_div">
	<div id="account_form">
		<? $hidden = array('did_submit' => 'true'); ?>
		<?= form_open('event/create_event_two/'.$event_id.'/'.$option, array('name'=>'my_form'), $hidden); ?>
			<label>Add Speakers:</label>
			<table cellpadding="0" cellspacing="0">
				<? if(count($candidates) > 0): ?>
					<tr>
						<th style="height: 25px; ">&nbsp;Name</th>
						<th colspan="2">&nbsp;Options</th>
					</tr>
					<? foreach($users AS $user): ?>
						<tr>
							<td style="padding: 3px 15px 3px 0px;"><?=$candidate['can_display_name']?></td>
							<td style="padding: 3px 4px 3px 0px;"><input type="button" value="Edit" onclick="window.location=site_url+'event/manage_candidate/<?=$event_id?>/<?=$user['user_id']?>';"></td>
							<td style="padding: 3px 4px 3px 0px;"><input type="button" value="Delete" onclick="if( confirm('Are you sure you want to delete the speaker \'<?=$user['display_name']?>\'?') ){ DeleteCandidate(<?=$user['user_id']?>); }"></td>
						</tr>
					<? endforeach; ?>
				<? else: ?>
					<tr>
						<td style="font-style: italic">There are not currently any speakers for this event.</td>
					</tr>
				<? endif; ?>
			</table>
			<br /><br />
			<input type="button" value="Add Speaker" onclick="window.location=site_url+'event/search_candidate/<?=$event_id?>';">
			<br /><br />
			<br /><br />
			<?if($option == 'edit'):?>
				<?= form_submit('','Update Information','class="button"'); ?>
			<? else: ?>
				<input type="button" onclick="window.location='event/create_event/<?=$event_id?>';" class="button" value="Last Step">
				<? if(count($candidates) > 0): ?>
					<?= form_submit('','Next Step','class="button"'); ?>
				<? else: ?>
					<input type="button" onclick="alert('You must have at least one speaker to continue.')" class="button" value="Next Step">
				<? endif; ?>
			<? endif; ?>
			<br /><br />
		<?= form_close(); ?>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	function DeleteCandidate(can_id){
		new Ajax.Request(site_url+'event/delete_speaker/'+can_id,
		  {
		    onSuccess: function(transport){
		      window.location = '<?=$this->config->site_url()?>event/create_event_two/<?=$event_id?>';
		    }
		  });
	}
</script>
<? $this->load->view('view_includes/footer.php'); ?>