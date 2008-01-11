<? 
$data['sub_title'] = $page_title." Step Two";
$this->load->view('view_layout/header.php', $data);
?>
<!--
	#dependency events.css
-->
<div id="content_div">
	<div id="title">
		<div class="top"></div>
		<h1>Create Event</h1>
	</div>
	<div style="padding-left: 10px;">
		Events allow community participation.
		<br /><br />
	</div>
	<div class="header">
		<h3>Event Speakers</h3>
	</div>
	<div id="account_form">
		<? $hidden = array('did_submit' => 'true'); ?>
		<?= form_open('event/create_event_two/'.$event_id.'/'.$option, array('name'=>'my_form'), $hidden); ?>
			<!-- <label>Add Speakers:</label> -->
			<table cellpadding="0" cellspacing="0">
				<? if(count($users) > 0): ?>
					<tr>
						<th style="height: 25px; ">&nbsp;Name</th>
						<th>Status</th>
						<th colspan="2">&nbsp;Options</th>
					</tr>
					<? foreach($users AS $user): ?>
						<tr>
							<td style="padding: 3px 15px 3px 0px;"><?=$user['display_name']?></td>
							<td style="padding: 3px 15px 3px 0px;">
								<?if($user['user_status']):?>
									<i>User has an active account.</i>
								<?else:?>
									<i>Email dispatched, awaiting activation.</i>
								<?endif;?>
							</td>
							<td style="padding: 3px 4px 3px 0px;">
								<?if($user['user_status'] || $user['creator_id'] != $current_user_id):?>
									<input type="button" style="width: 80px" value="Remove" onclick="if( confirm('Are you sure you want to remove the speaker \'<?=$user['display_name']?>\'?') ){ DeleteCandidate(<?=$user['user_id']?>); }">
								<?else:?>
									<input type="button" style="width: 80px" value="Delete" onclick="if( confirm('Are you sure you want to delete the speaker \'<?=$user['display_name']?>\'?') ){ DeleteCandidate(<?=$user['user_id']?>, 'delete'); }">
								<?endif;?>
							</td>
						</tr>
					<? endforeach; ?>
				<? else: ?>
					<tr>
						<td style="font-style: italic">There are not currently any speakers for this event.</td>
					</tr>
				<? endif; ?>
			</table>
			<br /><br />
			<input class="image" type="image" value="add speaker" src="images/many_one/button_add_speaker.png" name="add_speaker" onclick="window.location=site_url+'event/search_candidate/<?=$event_id?>';" />
			<br /><br />
			<br /><br />
			<?if($option == 'edit'):?>
				<?= form_submit('','Finish Updating','class="button"'); ?>
			<? else: ?>
				<input type="button" onclick="window.location='event/create_event/<?=$event_id?>';" class="button" value="Previous Step">
				<? if(count($users) > 0): ?>
					<?= form_submit('','Next Step','class="button"'); ?>
				<? else: ?>
					<input type="button" onclick="alert('You must have at least one speaker to continue.')" class="button" value="Add Event">
				<? endif; ?>
			<? endif; ?>
			<br /><br />
		<?= form_close(); ?>
	</div>
	<div style="margin-top: 20px">
		<strong>
		POWERED BY OPENFLOOR TECHNOLOGY
		</strong>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	function DeleteCandidate(user_id, option){
		new Ajax.Request(site_url+'event/delete_speaker/'+user_id+'/<?=$event_id?>/'+option,
		  {
		    onSuccess: function(transport){
		      window.location = '<?=$this->config->site_url()?>event/create_event_two/<?=$event_id?>/<?=$option?>';
		    }
		  });
	}
</script>
<? $this->load->view('view_layout/footer.php'); ?>