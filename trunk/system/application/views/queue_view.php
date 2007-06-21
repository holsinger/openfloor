<?$this->load->view('view_includes/header.php');
$this->load->plugin('question_plaque');?>
<div id="content_div">
	<h2>Questions</h2>
	<div id='queue'>
	<?
	foreach ($results as $row)
		$this->load->view('view_includes/view_question_pod.php',$row);
	?>
	</div>	
</div>
<?$this->load->view('view_includes/footer.php');?>