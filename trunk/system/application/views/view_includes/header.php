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
<!--  Add space -->

<center>add space</center>
<br /><br /><br />

<?
//set vars for tab and box top links
$this->load->view('view_includes/view_center_head.php'); 
?>

<? 
//set vars for right column
$this->load->view('view_includes/view_right_column.php'); 
?>

<? $this->load->view('view_includes/view_left_column.php'); ?>