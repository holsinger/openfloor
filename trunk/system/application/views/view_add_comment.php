<?
$data['red_head'] = 'Add comment';
?>

<?$this->load->view('view_includes/header.php',$data);?>

<div id="content_div">
	<h3>Add a comment</h3>
	<? 
	echo form_open('comment/addCommentAction')
	. form_format("Your comment: ",form_input('comment','','class="txt"') )
	. form_hidden('fk_question_id', $question_id)
	. '<input type="submit" value="Submit Comment"/>'
	. form_close();
	?>
</div>

<?$this->load->view('view_includes/footer.php');?>