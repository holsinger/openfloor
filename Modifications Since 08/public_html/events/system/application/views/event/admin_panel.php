<? 
$data['sub_title'] = "Admin Panel";
$this->load->view('view_layout/header.php', $data);
?>
<link rel="stylesheet" type="text/css" href="css/tabs.css" />
<link rel="stylesheet" type="text/css" href="css/events.css" />
<script type="text/javascript" charset="utf-8" src="javascript/dynamic_tabs.js"></script>
<div id="content_div">
	<div id="section">
		<a href="forums/cp/<?=$event_url_name?>">&lt; back to event</a>
		<ul class="tabnav">
			<li id="dyn_tab_1"><span id="dyn_text_1">General Information</span></li>
			<li id="dyn_tab_2"><span id="dyn_text_2">Speakers</span></li>
			<? if ($this->config->item('access_type')!= 'public') { ?>
				<li id="dyn_tab_3"><span id="dyn_text_3">Event Access</span></li>
			<?}?>
			<!-- <li id="dyn_tab_4"><span id="dyn_text_4">Permissions</span></li> -->
		</ul>
	</div>
	<div id="admin_content" style="position: relative; width: 90%"></div>
</div>
<script type="text/javascript" charset="utf-8">
	new Control.DynamicTabs(<?=$num_tabs;?>, 'admin_content', site_url+'event/admin_panel_tab_ajax/<?=$event_id?>/', { initial_tab: <?=$tab?> });
</script>
<? $this->load->view('view_layout/footer.php'); ?>