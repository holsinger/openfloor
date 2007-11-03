<?
$data['red_head'] = 'Questions';
$data['tabs'] = 'question';
$data['tab_view_question'] = 'active';
$data['event_url'] = "event/{$event['event_url_name']}";
$data['left_nav'] = 'event';

$options = array(
		'pending' => 'Pending',
		'current' => 'Current',
		'asked' => 'Asked',
		'deleted'  => 'Delete'
		);

$hidden = array("question_id" => $question['question_id'], "event_url_name" => $event['event_url_name']);
?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
	<h3>Edit a Question</h3>	
	<?= form_open('question/edit/'.$question['question_id'], "", $hidden); ?>
		<div class='errorArea'><?= isset($error)?$error:'' ?></div>
		
		<label>Question: </label>
		<small style="padding-bottom: 5px;">Enter a question you would like asked.</small><br />
		<input type="text" class="txt" id="question_name" size="48" maxlength="100" value="<?=$question['question_name']?>" name="question_name"/>
		<br />
		
		<label>Description: </label>
		<small style="padding-bottom: 5px;">Write a brief description explaining your question (limit 250 chars).</small><br />
		<textarea class="txt" maxlength="250" id="question_desc" rows="3" cols="48" name="question_desc"><?=$question['question_desc']?></textarea>
		
		<label>Question Status: </label><br />
		<?=form_dropdown('question_status', $options, $question['question_status'], 'id="question_status" onchange="ShowAnswerBox();"')?><br />
		
		<div id="answer_question_div" style="position: relative; visibility: hidden; display: none;">
			<label>Question Answer: </label>
			<small style="padding-bottom: 5px;">Write an answer to the question.</small><br />
			<textarea class="txt" id="question_answer" rows="3" cols="65" name="question_answer"><?=$question['question_answer']?></textarea>
		</div>
		
		<br /><br />
		<?= form_submit('','Update Question','class="button"'); ?>		
		<?= form_close(); ?>
</div>

<script type="text/javascript" charset="utf-8">
	function ShowAnswerBox(){
		if($('question_status').value == 'current' || $('question_status').value == 'asked'){
			$('answer_question_div').setStyle({
				visibility : 'visible',
				display: "block"
			});
		}else{
			$('answer_question_div').setStyle({
				visibility : 'hidden',
				display: "none"
			});
			$('question_answer').value = '';
		}
	}
	ShowAnswerBox();
</script>
<? $this->load->view('view_includes/footer.php'); ?>