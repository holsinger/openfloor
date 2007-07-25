<?
$data['red_head'] = $event_type.'s';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = $event_url;


//echo '<pre>'; print_r($data); echo '</pre>';


?>
<?$this->load->view('view_includes/header.php',$data);?>
<div id="content_div">
	<h3><?=$queue_title;?></h3>
	<? if(isset($ajax)) ob_clean(); //echo '<pre>'; print_r($data); echo '</pre>';?>
	<div id='queue'>
	<? if(!isset($ajax)): ?>
	<img src="<?=base_url();?>/images/nothing.gif" onLoad="queueUpdater.updateQueue();">
	<? endif; ?>
	<?
	if ($event_type == 'video')
	{
		foreach ($results as $row)
			$this->load->view('view_includes/view_video_pod.php',$row);
	}
	else 
	{		
		foreach ($results as $row)
		$this->load->view('view_includes/view_question_pod.php',$row);
	}
	
	if (isset($question_view) && !$ajax) {
		$this->load->library('comments_library');
		$comments_library = new Comments_library($vars);
		$comments_library->createComments($vars);
		$submit = ($this->userauth->isUser()) ? '<input type="submit" value="Submit Comment"/>' : '<br/><div id="userLogin"><span onclick="showBox(\'login\');">Login to comment</span></div>' ;
		?>
		<div id="content_div">
			<h3>Add a comment</h3>
			<?
			$data = array('class' => 'txt', 'name' => 'comment', 'rows' => 3, 'cols' => 60);
			echo form_open('comment/addCommentAction')
			. form_format("Your comment: ",form_textarea($data) )
			. form_hidden('fk_question_id', $results[0]['question_id'])
			. form_hidden('event_name', url_title($results[0]['event_name']))
			. form_hidden('question_name', $results[0]['question_name'])
			. $submit
			. form_close();
			?>
		</div>
		<?
	}
	
	?>
	<p><?=empty($results)?'There are no questions to display':''?>
	<p><?=(!isset($question_view) && !empty($results))?$this->pagination->create_links():''?></p>
	<p><?=(isset($cloud) && !isset($question_view))?$cloud:''?></p>
	</div>
	<? if(isset($ajax))	ob_end_flush(); ?>
</div>
<?$this->load->view('view_includes/footer.php');?>