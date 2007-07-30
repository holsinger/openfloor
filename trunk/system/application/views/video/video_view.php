<?
$this->load->view('view_includes/header.php');

$this->load->library('comments_library');
$comments_library = new Comments_library();
//$results[0]['comments_body'] = $comments_library->createComments($results);

//$attributes = array('class' => 'txt', 'name' => 'comment', 'rows' => 3, 'cols' => 40);
/*$submit = ($this->userauth->isUser()) ? 
	'<input type="submit" value="Submit Comment"/>' : 
	'<br/><div id="userLogin"><span onclick="showBox(\'login\');">Login to comment</span></div>' ;*/
/*$results[0]['comments_body'] .=  '
<div id="content_div">
	<h3>Add a comment</h3>'
	. form_open('comment/addCommentAction')
		. form_format("Your comment: ",form_textarea($attributes) )
		. form_hidden('fk_question_id', $results[0]['question_id'])
		. form_hidden('event_name', url_title($results[0]['event_name']))
		. form_hidden('question_name', $results[0]['question_name'])
		. $submit
	. form_close()
. '</div>';*/

$this->load->view('view_includes/view_video_pod.php',$results[0]);

$this->load->view('view_includes/footer.php');
?>