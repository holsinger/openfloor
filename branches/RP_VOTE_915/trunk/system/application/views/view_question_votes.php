<?
$data['red_head'] = 'Votes';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = 'event/'.$event_url_name;
$data['left_nav'] = 'event';

$this->load->view('view_includes/header.php',$data);
$this->load->view('view_includes/view_question_pod');
$this->load->view('view_includes/footer.php');  
?>
	