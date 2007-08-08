<? 
//set vars the will detemine the head tag 
$data['browser'] = $this->agent->browser();
$data['browserVer'] = $this->agent->version();

//setup onLoad array
if (isset($data['js_onload']) && is_array($data['js_onload'])) $onload = implode('();',$data['js_onload']).'();';
else $onload = 'init();';
$this->load->view('view_includes/view_head_setup.php',$data);
?>
<? if ($data['browser'] == 'Internet Explorer' && $data['browserVer'] < 7) { ?>
<body onLoad='fixPNG();<?=$onload;?>'>
<?}else{?>
<body onLoad='<?=$onload;?>'>
<?}?>
<!--  load AJAX views -->
<div id="overlay" onclick="hideBox()" style="display:none"></div>
<div id="hijax" style="display:none"></div>
<? //$this->load->view('ajax/aview_zip_nine.php'); ?>
<? $this->load->view('ajax/aview_login.php'); ?>

<? $this->load->view('view_includes/view_head_body.php'); ?>	
<!--  Ad space -->

<br /><br /><br />

<?
//set vars for tab and box top links
$data['tabs'] = (isset($tabs)) ? $tabs:FALSE;
$data['admin'] = (isset($admin)) ? $admin:FALSE;
$data['tab_view_question'] = (isset($tab_view_question)) ? $tab_view_question:'';
$data['tab_submit_question'] = (isset($tab_submit_question)) ? $tab_submit_question:'';
$data['event_url'] = (isset($event_url)) ? $event_url:'';
$data['red_head'] = (isset($red_head)) ? $red_head:'';
$data['sort_array'] = (isset($sort_array)) ? $sort_array:'';
$data['breadcrumb'] = (isset($breadcrumb)) ? $breadcrumb:array('Home'=>$this->config->site_url());
if ($this->userauth->isAdmin()) $data['breadcrumb']['Admin'] = '/admin';
$this->load->view('view_includes/view_center_head.php',$data); 
?>

<? 
//set vars for right column
//$data['rightpods'] = (isset($rightpods)) ? $rightpods:array('gvideo'=>array(),'gblog'=>array());
$data['rightpods'] = (isset($rightpods)) ? $rightpods:array('events'=>array(),'gvideo'=>array(),'gblog'=>array(),'dynamic'=>array());
if (isset($cloud)) {
	$data['rightpods']['dynamic']['tag_cloud']= $cloud;
} else $data['cloud'] = FALSE;


if (!$data['admin']) $this->load->view('view_includes/view_right_column.php',$data); 
?>

<? if (!$data['admin'])  $this->load->view('view_includes/view_left_column.php'); ?>