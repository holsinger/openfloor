<? 
$data['sub_title'] = "Site Administration";
$data['admin'] = TRUE;
$data['left_nav'] = 'admin';
$this->load->view('view_layout/header.php', $data);
?>
<!--
	#dependency tabs.css
	#dependency dynamic_tabs.js
-->
<div id="content_div">
	<div id="section">
		<ul class="tabnav">
			<li id="dyn_tab_1"><span id="dyn_text_1">Content</span></li>
			<li id="dyn_tab_2"><span id="dyn_text_2">Users</span></li>
			<li id="dyn_tab_3"><span id="dyn_text_3">Site Settings</span></li>
		</ul>
	</div>
	<div id="site_admin_content" style="position: relative; width: 90%;"></div>
</div>
<script type="text/javascript" charset="utf-8">
	new Control.DynamicTabs(3, 'site_admin_content', site_url+'admin/site_admin_ajax/', { initial_tab: 1 });
</script>
<? $this->load->view('view_layout/footer.php'); ?>