<div class="link" onclick="showBox('question_suggestions');">Learn how to ask great questions here.</div>
	
<?= form_open('question/add/'.$event_url, array('id' => 'add_question_form')); ?>
	<div class='errorArea'><?= isset($error)?$error:'' ?></div>		
		
	<? if ($event_id>0) { ?>
		<?//=$event_name;?>
		<?= form_hidden('event',$event_id); ?>
	<? } else { ?>
		<label>Event: *</label>
		<select name="event" class="txt">
			<option value="0">-- Select an Event --</option>
			<?=$data['vars']['events']?>
		</select>
	<? } ?>
	<br />
	<?
	$format = array(
              'name'        => 'question',
              'id'          => 'question',
              'value'       => $this->validation->question,
              'maxlength'   => '100',
              'size'        => '48',
              'class'       => 'txt'
            );		
	echo form_format("Question: *",form_input($format),'Enter a question you would like asked.' );
	?>
	<br />
	<?
	$format = array(
          'name'        => 'desc',
          'id'          => 'desc',
          'value'       => $this->validation->desc,
          'maxlength'   => '250',
          'rows'        => '3',
          'cols'        => '48',
          'class'       => 'txt'
        );
	echo form_format("Description: ",form_textarea($format),'Write a brief description explaining your question (limit 250 chars).' ); 
	?>
	<br />
	<?
	$format = array(
          'name'        => 'tags',
          'id'          => 'tags',
          'value'       => $this->validation->tags,
          'size'        => '48',
          'class'       => 'txt',
		  'style'	    => 'text-transform:lowercase'
        );
	echo form_format("Tags: ",form_input($format),'Short, generic words separated by spaces example: abortion war politics' ); 
	?>
	<br />
	<br />
	<?= form_hidden('submitted','true'); ?>
	<?= form_hidden('event_url',$event_url); ?>
	<div class="link" onclick="showBox('disclaimer');">Disclaimer</div>
	<br />
	<? if(isset($ajax)): ?>
		<?/*<a onClick="javascript:cpUpdater.askQuestion();">Submit Question</a>*/?>
		<input type="button" value='Submit Question' class="button" onClick="javascript:cpUpdater.askQuestion();">
		<input type="button" value='Cancel' class="button" onClick="$('cp-ask-question').setStyle({display: 'none'});"/>
	<? else: ?>
		<?= form_submit('','Submit '.ucfirst($event_type),'class="button"'); ?>		
	<? endif; ?>
	<br />
	<br />
	<small>* required fields</small>
<?= form_close(); ?>