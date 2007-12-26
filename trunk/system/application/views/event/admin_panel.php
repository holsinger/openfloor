<? 
$data['sub_title'] = "Admin Panel";
$this->load->view('view_includes/header.php', $data);
?>
<!--
	#dependency tabs.css
	#dependency events.css
	#dependency dynamic_tabs.js
-->
<div id="content_div">
	<div id="section">
		<ul class="tabnav">
			<li id="dyn_tab_1"><span id="dyn_text_1">General Information</span></li>
			<li id="dyn_tab_2"><span id="dyn_text_2">Speakers</span></li>
			<li id="dyn_tab_3"><span id="dyn_text_3">Additional Information</span></li>
			<!-- <li id="dyn_tab_4"><span id="dyn_text_4">Permissions</span></li> -->
		</ul>
	</div>
	<div id="admin_content" style="position: relative; width: 90%"></div>
</div>
<script type="text/javascript" charset="utf-8">
	new Control.DynamicTabs(3, 'admin_content', site_url+'event/admin_panel_tab_ajax/<?=$event_id?>/', { initial_tab: <?=$tab?> });
</script>
<? $this->load->view('view_includes/footer.php'); ?>