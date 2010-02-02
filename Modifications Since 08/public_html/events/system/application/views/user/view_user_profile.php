<?
$data['red_head'] = 'Welcome';
$data['sub_title'] = 'User Profile'; 
if (!$ajax) $this->load->view('view_layout/header.php',$data); 
?>
<!--
	#dependency tabs.css
	#dependency dynamic_tabs.js
-->
<div id="content_div">
	<div style="float: left">
		<img src="<?=$avatar_image_path?>">
	</div>
	<div style="float: left; margin-left: 15px">
		<strong><?=$display_name?></strong>
	</div>
	<div style="float: left; padding-left: 80px; width: 500px; font-weight: bold;"><a>The user profile is also your "Inbox". You can update your personal information from this page and more. This is where you can see the all important alerts, like when a student asks you a private question, or a student flags a question as inappropriate--which hopefully won't happen too often. The tabs across the bottom help you keep track of your virtual fingerprint in the OpenFloor system.</a></div>
	<br /><br />
	<? if (!$ajax) {?>
	<br /><br /><br />
	
		<div class="errorArea">
			<h3>Alerts: <?php if ($this->session->userdata['inbox_count'] == 0):?>you have no alerts.<?php else:?>you have <?=$this->session->userdata['inbox_count']?> alerts.<?php endif;?></h3>
			<? foreach ($alert['event'] as $k => $event):?>
			<strong>The event "<?=$event['event_name']?>" is approaching and you are the respondent/creator.</strong><br />
			<?endforeach;?>
			<? if ($this->userauth->isAdmin()):?>
				<br />
				<? foreach ($alert['attention'] as $k => $attention):?>
				<strong>The question "<?=$attention['question_name']?>" is flagged.</strong><br />
				<?endforeach;?>
			<?endif;?>
			<? if (!$this->userauth->isAdmin()):?>
			<br />
				<? foreach ($alert['flagged'] as $k => $flagged):?>
				<strong>The question "<?=$flagged['question_name']?>" is flagged.</strong><br />
				<?endforeach;?>
			<?endif;?>
			<br />
			<? foreach ($alert['private'] as $k => $private):?>
			<strong>The question "<?=$private['question_name']?>" is a private question.</strong><br />
			<?endforeach;?>
		</div>	<br />
	<div id="section">
		<ul class="tabnav">
			<li id="dyn_tab_1"><span id="dyn_text_1">User Information</span></li>
			<li id="dyn_tab_2"><span id="dyn_text_2">Asked</span></li>
			<li id="dyn_tab_3"><span id="dyn_text_3">Votes Cast</span></li>
			<li id="dyn_tab_4"><span id="dyn_text_4">Comments</span></li>
			<li id="dyn_tab_5"><span id="dyn_text_5">You Flagged</span></li>
			<? if ($this->userauth->isAdmin()):?>
			<li id="dyn_tab_6"><span id="dyn_text_6">Expiring</span></li>
			<? endif;?>
			<? if (!$this->userauth->isAdmin()):?>
			<li id="dyn_tab_6"><span id="dyn_text_6">Flagged You</span></li>
			<? endif;?>
			<li id="dyn_tab_7"><span id="dyn_text_7">Answered</span></li>
			<li id="dyn_tab_8"><span id="dyn_text_8">Private</span></li>
			<? if (!$this->userauth->isAdmin()):?>
			<li id="dyn_tab_9"><span id="dyn_text_9">Event Request</span></li>
			<? else:?>
			<li id="dyn_tab_9" style="display: none;"><span id="dyn_text_9">Event Request</span></li>
			<? endif;?>
			<? if ($this->userauth->isAdmin()):?>
			<li id="dyn_tab_10"><span id="dyn_text_10">Accounts Frozen</span></li>
			<? endif;?>
			<? if (!$this->userauth->isAdmin()):?>
			<li id="dyn_tab_10"><span id="dyn_text_10">Feedback</span></li>
			<? endif;?>
		</ul>
	</div>
	<br />
	<div id="user_content" style="position: relative; width: 90%"></div>
  	<div class='errorArea'><?=$error?></div>
	<? } else {?>
		<div id="user_content" style="position: relative; width: 300px;"><strong>Bio:</strong><?=$bio;?></div>
	<?}?>
</div>
<script type="text/javascript" charset="utf-8">
new Control.DynamicTabs(10, 'user_content', site_url+'user/profile_ajax/<?=$user_id?>/');

</script>
<? if (!$ajax) $this->load->view('view_layout/footer.php'); ?>  				