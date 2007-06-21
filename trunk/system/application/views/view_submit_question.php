<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
	<h2>Submit a Question</h2>	
	<?= form_open('question'); ?>
		<div class='errorArea'><?= isset($error)?$error:'' ?></div>		
		<label>Event</label>
		<select name="event" class="txt">
			<option value="0">-- Select an Event --</option>
			<?=$data['vars']['events']?>
		</select>
		<br />
		<?
		$format = array(
              'name'        => 'question',
              'id'          => 'question',
              'value'       => $this->validation->question,
              'maxlength'   => '150',
              'size'        => '100',
              'class'       => 'txt'
            );
		echo form_format("Question: ",form_input($format),'Enter a question you would like asked.' ); 
		?>
		<br />
		<?
		$format = array(
              'name'        => 'desc',
              'id'          => 'desc',
              'value'       => $this->validation->desc,
              'maxlength'   => '250',
              'rows'        => '3',
              'cols'        => '75',
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
              'size'        => '75',
              'class'       => 'txt',
			  'style'	    => 'text-transform:lowercase'
            );
		echo form_format("Tags: ",form_input($format),'Short, generic words separated by \',\' (commas) example: abortion, lgbt, war' ); 
		?>
		<br />
		<br />
		<?= form_hidden('submitted','true'); ?>
		<?= form_submit('','Submit Question','class="button"'); ?>
	<?= form_close(); ?>
</div>

<? $this->load->view('view_includes/footer.php'); ?>