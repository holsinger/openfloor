<!--
	#dependency queueUpdater.js
-->
<?
$data['red_head'] = $event_type;
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = 'event/' . url_title($event_name);
$data['left_nav'] = 'event';
$data['sub_title'] = $question_name;

$this->load->view('view_includes/header.php', $data);?>
<script type="text/javascript" charset="utf-8">
	// Initialize, used in view_question_pod.php
	// queueUpdater.updateQueue();
</script>
<?
$this->load->view('view_includes/view_question_pod.php');
$this->load->view('view_includes/footer.php');
?>
	