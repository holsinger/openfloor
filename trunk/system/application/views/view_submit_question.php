<? $this->load->view('view_includes/header.php'); ?>

<div align="center">
	<form method="post" action="index.php/question">
		<?= isset($data['vars']['success'])?'<h3>SUCCESS!</h3>':'' ?>
		<h3>Event</h3>
		<select name="event">
			<option value="0"></option>
			<?=$data['vars']['events']?>
		</select>
		<h3>Question</h3>
		Enter a question you would like asked.<br/>
		<input type="text" name="question" maxlength="100"/>
		<h3>Description</h3>
		Write a brief description explaining your question (limit 250 chars).<br/>
		<textarea rows="2" cols="20" name="desc">y helo thar</textarea>
		<h3>Tags</h3>
		Short, generic words separated by ',' (commas) ex...<br/>
		<input type="text" name="tags"/><br/><br/>
		<input type="submit" value="Submit Question"/>
		<input type="hidden" name="submitted" value="true"/>
	</form>
</div>

<? $this->load->view('view_includes/footer.php'); ?>