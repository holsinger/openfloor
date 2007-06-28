<?
$data['red_head'] = 'Questions';
$data['tabs'] = TRUE;
$data['tab_view_question'] = 'active';
?>
<?$this->load->view('view_includes/header.php',$data);?>
<div id="content_div">
	<h3>View Questions</h3>
	<div id='queue'>
	<?
	foreach ($results as $row)
		$this->load->view('view_includes/view_question_pod.php',$row);
	?>
	</div>	
</div>
<?$this->load->view('view_includes/footer.php');?>