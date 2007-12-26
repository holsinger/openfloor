<?
$data['red_head'] = 'Welcome';
$data['sub_title'] = 'User Profile'; 
$this->load->view('view_includes/header.php',$data); 
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
	<br /><br /><br />
	<br /><br /><br />
	<div id="section">
		<ul class="tabnav">
			<li id="dyn_tab_1"><span id="dyn_text_1">User Information</span></li>
			<li id="dyn_tab_2"><span id="dyn_text_2">Question History</span></li>
			<li id="dyn_tab_3"><span id="dyn_text_3">Vote History</span></li>
		</ul>
	</div>
	<br />
	<div id="user_content" style="position: relative; width: 90%"></div>
  	<div class='errorArea'><?=$error?></div>
</div>
<script type="text/javascript" charset="utf-8">
	new Control.DynamicTabs(3, 'user_content', site_url+'user/profile_ajax/<?=$user_id?>/');
</script>
<? $this->load->view('view_includes/footer.php'); ?>  				