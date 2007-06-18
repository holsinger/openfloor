<?php
include_once 'includes/header.php'; 

/* begin logic */

if (!empty($_POST)) {
	echo 'DEBUG:<pre>';
	print_r($_POST);
	echo '</pre>';
}

/* end logic */

echo '
<div align="center">
	<form method="post" action="'.$_SERVER['PHP_SELF'].'">
		<h3>Event</h3>
		<select name="event">
			<option value="">Mitt Romney</option>
		</select>
		<h3>Question</h3>
		Enter a question you would like asked.<br/>
		<input type="text" name="question"/>
		<h3>Description</h3>
		Write a brief description explaining your quesiton (limit 250 chars).<br/>
		<textarea rows="2" cols="20" name="desc">y helo thar</textarea>
		<h3>Tags</h3>
		Short, generic words separated by \',\' (commas) ex...<br/>
		<input type="text" name="tags"/><br/><br/>
		<input type="submit" value="Submit Question"/>
		<input type="hidden" name="submitted" value="true"/>
	</form>
</div>
';

include_once 'includes/footer.php';