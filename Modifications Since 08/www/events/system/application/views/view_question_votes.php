<?
$data['red_head'] = 'Votes';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = 'event/'.$event_url_name;
$data['left_nav'] = 'event';
$data['sub_title'] = '"'.$question_name.'" Vote History'; 

$this->load->view('view_layout/header.php',$data);
$this->load->view('view_includes/view_question_pod');
$this->load->view('view_layout/footer.php');
?>
	