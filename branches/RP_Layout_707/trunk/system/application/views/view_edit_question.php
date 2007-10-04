<?
$data['red_head'] = 'Questions';
$data['tabs'] = 'question';
$data['tab_view_question'] = 'active';
$data['event_url'] = "event/{$event['event_url_name']}";
$data['left_nav'] = 'event';
?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
	<h3>Edit a Question</h3>	
	<?= form_open('question/edit/'.$question['question_id']); ?>
		<div class='errorArea'><?= isset($error)?$error:'' ?></div>
		<? echo form_format("Question:",anchor("event/{$event['event_url_name']}/question/".url_title($question['question_name']),$question['question_name']),'' ); ?>
		<? echo form_format("Question Status: *",$dropdown,'' ); ?>
		<?
		if ($question['question_status'] == 'current' || $question['question_status'] == 'asked')
		{
			$format = array(
	              'name'        => 'question_answer',
	              'id'          => 'question_answer',
	              'value'       => $question['question_answer'],
	              'rows'        => '6',
	              'cols'        => '75',
	              'class'       => 'txt'
	            );
			echo form_format("Question Answer: *",form_textarea($format),'Write a the answer to the question.' );
		}
		?>
		<? echo form_hidden("question_id",$question['question_id']); ?>  
		<? echo form_hidden("event_url_name",$event['event_url_name']); ?>
		<br /><br />
		<?= form_submit('','Edit Question','class="button"'); ?>		
		<?= form_close(); ?>
</div>

<? $this->load->view('view_includes/footer.php'); ?>