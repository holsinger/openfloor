<?$this->load->view('view_includes/header.php');
$this->load->plugin('question_plaque');?>
<h2 align="center">Questions</h2>
<div align="center">
<?foreach ($results as $row)
	echo create_plaque($row);?>
</div>	
<?$this->load->view('view_includes/footer.php');?>