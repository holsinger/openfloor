<?php
	$other_question_array = array();
	$result_question_array = array();
	foreach ($other_questions as $k => $data){
		$other_question_array[] = array('id' => 'other_question_'.$data['question_id'],
										'name' => 'other_questions_' . $question['question_id'] . '_[]',
										'value' => $data['question_id'],
										'label' => $data['question_name'],
										'checked' => FALSE);
		$result_question_array[$data['question_id']] = $data['question_name'];
	}
?>
<div id="question_flag_div" style="padding: 3px;">
	<form id="question_flag_form_<?=$question['question_id']?>">
		<div class='errorArea' id="question_error_div"></div>
		<?=form_format("Question:", $question['question_name']); ?>
		<?=form_format("Flag: ",form_radio('flag_radio_' . $question['question_id'],'1',true,'onclick="document.getElementById(\'merge_div_' . $question['question_id'] . '\').style.display = \'none\';"'));echo "Inappropriate"?>
		<?=form_format("",form_radio('flag_radio_' . $question['question_id'],'3',false,'onclick="document.getElementById(\'merge_div_' . $question['question_id'] . '\').style.display = \'none\';"'));echo "Private"?>
		<?php if ($this->userauth->isAdmin()) {?>
			<?=form_format("",form_radio('flag_radio_' . $question['question_id'],'4',false,'onclick="document.getElementById(\'merge_div_' . $question['question_id'] . '\').style.display = \'none\';"'));echo "Promoted"?>
		<?php }?>
		<?=form_format("",form_radio('flag_radio_' . $question['question_id'],'2',false,'onclick="document.getElementById(\'merge_div_' . $question['question_id'] . '\').style.display = \'block\';"'));echo "Duplicate"?>
		<div id="merge_div_<?=$question['question_id']?>" style="display: none;margin-left:30px;">
			<?=form_format("",form_radio('merge_radio_' . $question['question_id'],'1',true,'onclick="document.getElementById(\'other_questions_' . $question['question_id'] . '_1\').style.display = \'none\';"'));echo "MERGE A SIMILAR QUESTION"?>
			<?=form_format("",form_radio('merge_radio_' . $question['question_id'],'2',false,'onclick="document.getElementById(\'other_questions_' . $question['question_id'] . '_1\').style.display = \'block\';"'));echo "MERGE DUPLICATE QUESTIONS"?>
			<div id="other_questions_<?=$question['question_id']?>_0" style="display: block;margin-left:30px;margin-top:10px;">
			<?php 
				echo form_format("","<b>Selcet a question as result.</b><br><br>");
				echo form_format("",form_dropdown('result_question_' . $question['question_id'], $result_question_array));
			?>
			</div>
			<div id="other_questions_<?=$question['question_id']?>_1" style="display: none;margin-left:30px;margin-top:10px;">
			<?php
				echo form_format("","<b>Select other duplicate questions.</b><br><br>");
				foreach ($other_question_array as $k => $data) { 
					echo form_format("",form_checkbox($data));echo $data['label'] . '<br>';
				}
			?>
			</div>
		</div>
		<br /><br />
		<input type="button" class="button" value="Flag Question" onclick="new Ajax.Request(site_url+'flag/flagQuestion/<?=$question['question_id']?>/<?=$this->session->userdata['user_id']?>/flag', { parameters: $('question_flag_form_<?=$question['question_id']?>').serialize(true), onSuccess : cpUpdater.FlagQuestionOnSucess });">	
	</form>
</div>