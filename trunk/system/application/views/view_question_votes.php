<?
$data['red_head'] = 'Votes';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';

$this->load->view('view_includes/header.php',$data);
$this->load->view('view_includes/view_question_pod');
$this->load->view('view_includes/footer.php');
?>
	