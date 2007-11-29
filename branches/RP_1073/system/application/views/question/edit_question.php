<?
$options = array(
		'pending' => 'Pending',
		'current' => 'Current',
		'asked' => 'Asked',
		'deleted'  => 'Delete'
		);
$desc_format = array(
      'name'        => 'question_desc',
      'id'          => 'question_desc',
      'value'       => $question['question_desc'],
      'maxlength'   => '250',
      'rows'        => '3',
      'cols'        => '48',
      'class'       => 'txt'
    );	
$answer_format = array(
      'name'        => 'question_answer',
      'id'          => 'question_answer',
      'value'       => $question['question_answer'],
      'rows'        => '6',
      'cols'        => '65',
      'class'       => 'txt'
);
?>

<div id="content_div" style="padding: 3px;">
	<form id="question_edit_form">
		<div class='errorArea' id="question_error_div"></div>
		<?=form_format("Question:",form_input('question_name', $question['question_name'], 'class="txt"'),'' ); ?>
		<?=form_format("Description: ",form_textarea($desc_format),'(limit 250 chars)' );?>
		<?=form_format("Question Status: *", form_dropdown('question_status', $options, $question['question_status'], 'onchange="cpUpdater.ChangeQuestionStatus(this)"'),'' ); ?>
		<?=form_hidden("start_status", $question['question_status'])?>
		<div id="question_status_div" style="display: <?=$question['question_status'] == 'current' || $question['question_status'] == 'asked' ? 'block' : 'none'?>;">
			<?=form_format("Question Answer: *",form_textarea($answer_format),'Write a the answer to the question.' );?>
		</div>
		<br /><br />
		<input type="button" class="button" value="Update Question" onclick="new Ajax.Request(site_url+'forums/EditQuestion/<?=$question['question_id']?>/update', { parameters: $('question_edit_form').serialize(true), onSuccess : cpUpdater.UpdateQuestionOnSucess });">	
	</form>
</div>