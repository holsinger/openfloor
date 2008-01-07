<? 
//set vars the will detemine the head tag 
$data['browser'] = $this->agent->browser();
$data['browserVer'] = $this->agent->version();

//setup onLoad array
if (isset($data['js_onload']) && is_array($data['js_onload'])) {
	$onload = implode('();',$data['js_onload']).'();';
}else{
	$onload = 'init();';
} 
$this->load->view('view_layout/view_head_setup.php',$data);
?>
<body onLoad='<?=$onload;?>'>
	<!--  load AJAX views -->
	<div id="overlay" onclick="hideBox()" style="display:none"></div>
	<div id="hijax" style="display:none"></div>
	<?
	$this->load->view('ajax/aview_login.php'); 				// Content for login stuff
	$this->load->view('view_layout/view_head_body.php');	// Body of the header section
	?>
	<!--  Ad space -->
	<?
	//set vars for tab and box top links
	$data['tabs'] = (isset($tabs)) ? $tabs:FALSE;
	$data['admin'] = (isset($admin)) ? $admin:FALSE;
	$data['tab_view_question'] = (isset($tab_view_question)) ? $tab_view_question:'';
	$data['tab_submit_question'] = (isset($tab_submit_question)) ? $tab_submit_question:'';
	$data['event_url'] = (isset($event_url)) ? $event_url:'';
	$data['red_head'] = (isset($red_head)) ? $red_head:'';
	$data['sort_array'] = (isset($sort_array)) ? $sort_array:'';
	$data['left_nav'] = (isset($left_nav)) ? $left_nav:'';
	$data['breadcrumb'] = (isset($breadcrumb)) ? $breadcrumb:array('Home'=>$this->config->site_url());
	// LEFT COLUMN
	$this->load->view('view_layout/view_left_column.php',$data); 
	?>
	<? if($sub_title): ?>
	<div class="double_line_container">
			<h1><?=$sub_title?></h1>
	</div>
	<? endif; ?>
	<? if(isset($breadcrumb)): ?>
		<div>
			<?
			foreach ($breadcrumb as $key => $link){
				if($link != ""){
					echo anchor($link,$key)."&nbsp;>&nbsp;";
				}else{
					echo $key;
				}
			}
			?>
		</div>
		<br />
	<? endif; ?>