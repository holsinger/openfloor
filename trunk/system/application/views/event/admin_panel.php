<? 
$data['sub_title'] = "Admin Panel";
$this->load->view('view_includes/header.php', $data);

if($tab == 'one'){
	$tab_1_class = "selected";
}else if($tab == 'two'){
	$tab_2_class = "selected";
}else if($tab == 'three'){
	$tab_3_class = "selected";
}else if($tab == 'four'){
	$tab_4_class = "selected";
}
?>
<!--
	#dependency events.css
-->
<div id="content_div">
	<div id="section">
		<ul class="tabnav">
			<li id="tab1" class="<?=$tab_1_class?>"><a id="link1" class="<?=$tab_1_class?>" href="javascript: var none = ChangeTab('one');">General Information</a></li>
			<li id="tab2" class="<?=$tab_2_class?>"><a id="link2" class="<?=$tab_2_class?>" href="javascript: var none = ChangeTab('two');">Speakers</a></li>
			<li id="tab3" class="<?=$tab_3_class?>"><a id="link3" class="<?=$tab_3_class?>" href="javascript: var none = ChangeTab('three');">Additional Information</a></li>
			<li id="tab4" class="<?=$tab_4_class?>"><a id="link4" class="<?=$tab_4_class?>" href="javascript: var none = ChangeTab('four');">Permissions</a></li>
		</ul>
	</div>
	<br />
	<div id="admin_content" style="position: relative; width: 90%">
		<? $this->load->view('event/admin_panel_tab_'.$tab.'.php'); ?>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	function ChangeTab(tab){
		// Reset tab classes to non-selected
		tabs = ['tab1', 'tab2', 'tab3', 'tab4'];
		tabs.each(function(s) {
			if($(s).hasClassName('selected')) {
				$(s).removeClassName('selected');
			}
		});
		// Reset link classes to non-selected
		links = ['link1', 'link2', 'link3', 'link4'];
		links.each(function(s) {
			if($(s).hasClassName('selected')) {
				$(s).removeClassName('selected');
			}
		});
		// Add classes for newly selected
		if(tab == 'one'){
			$('tab1').addClassName('selected');
			$('link1').addClassName('selected');
		}else if(tab == 'two'){
			$('tab2').addClassName('selected');
			$('link2').addClassName('selected');
		}else if(tab == 'three'){
			$('tab3').addClassName('selected');
			$('link3').addClassName('selected');
		}else if(tab == 'four'){
			$('tab4').addClassName('selected');
			$('link4').addClassName('selected');
		}
		// Update Content Section
		new Ajax.Updater('admin_content', site_url+'event/admin_panel_tab_ajax/<?=$event_id?>/'+tab);
	}
</script>
<? $this->load->view('view_includes/footer.php'); ?>