<body onLoad='<?=$onload;?>'>
	<!--  load AJAX views -->
	<!--		
		#dependency all2.css
		#dependency main.css
		#dependency flag.css
		#dependency wordcloud.css
	-->
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
	if ($left_nav != 'dashboard') $this->load->view('view_layout/view_left_column.php',$data); 
	?>
	<td class="col-center" valign="top" <?=$override_td_style?>>
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