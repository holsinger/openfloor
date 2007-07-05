<? 
//set vars the will detemine the head tag 

$this->load->view('view_includes/view_head_setup.php');
?>
<body>
<!--  load AJAX views -->
<div id="overlay" onclick="hideBox()" style="display:none"></div>
<? //$this->load->view('ajax/aview_zip_nine.php'); ?>
<? $this->load->view('ajax/aview_login.php'); ?>

<? $this->load->view('view_includes/view_head_body.php'); ?>	
<!--  Ad space -->

<center>ad space</center>
<br /><br /><br />

<?
//set vars for tab and box top links
$data['tabs'] = (isset($tabs)) ? $tabs:FALSE;
$data['tab_view_question'] = (isset($tab_view_question)) ? $tab_view_question:'';
$data['tab_submit_question'] = (isset($tab_submit_question)) ? $tab_submit_question:'';
$data['event_url'] = (isset($event_url)) ? $event_url:'';
$data['red_head'] = (isset($red_head)) ? $red_head:'';
$data['sort_array'] = (isset($sort_array)) ? $sort_array:'';
$data['breadcrumb'] = (isset($breadcrumb)) ? $breadcrumb:array('Home'=>$this->config->site_url());
$this->load->view('view_includes/view_center_head.php',$data); 
?>

<? 
//set vars for right column
$this->load->view('view_includes/view_right_column.php'); 
?>

<? $this->load->view('view_includes/view_left_column.php'); ?>