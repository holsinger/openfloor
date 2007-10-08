<?
$data['red_head'] = $event_type.'s';
$data['tabs'] = $event_type;
$data['tab_submit_question'] = 'active';
$data['event_url'] = $event_url;
$data['left_nav'] = 'event';
?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
	<h3>Submit a <?=ucfirst($event_type);?></h3>	
	<?= form_open('video/add/'.$event_url); ?>
		<div class='errorArea' id='errorArea'><?= isset($error)?$error:'' ?></div>		
		<label>Event: *</label>
		
		<? if ($event_id>0) { ?>
			<?=$event_name;?>
			<?= form_hidden('event',$event_id); ?>
		<? } else { ?>
			<select name="event" class="txt">
				<option value="0">-- Select an Event --</option>
				<?=$data['vars']['events']?>
			</select>
		<? } ?>
		<br />
		<?
		$format = array(
	              'name'        => 'youtube',
	              'id'          => 'youtube',
	              'value'       => $this->validation->youtube,
	              'maxlength'   => '150',
	              'size'        => '50',
	              'class'       => 'txt',
								//'onBlur'      => 'ajaxVideo.youTubeVideoDetails(this.value);'
	            );
		
		echo form_format("YouTube Video ID: *",form_input($format),'Enter the '.anchor('http://youtube.com','YouTube',"style='text-decoration:none;'").' Video ID for your entry. <span class="link" onclick="showBox(\'youtube_id\');">Help me find my YouTube Video ID.</span>' );
		?>
		<br />
		<br />
		<div id='videoNext'><input value='Next >' type="button" id="videoDetailsButton" class="button" onClick="ajaxVideo.youTubeVideoDetails(document.getElementById('youtube').value);"></div>
		<br />
		<div id='videoDetails' style="display:none;">
		
		<?
		$format = array(
	              'name'        => 'video',
	              'id'          => 'video',
	              'value'       => $this->validation->video,
	              'maxlength'   => '150',
	              'size'        => '50',
	              'class'       => 'txt'
	            );
		
		echo form_format("Video Title: *",form_input($format),'Enter the title for your video entry.' );
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
		echo form_format("Description: ",form_textarea($format),'Write a brief description explaining your video (limit 250 chars).' ); 
		?>
		<br />
		<?
		$format = array(
              'name'        => 'tags',
              'id'          => 'tags',
              'value'       => $this->validation->tags,
              'size'        => '50',
              'class'       => 'txt',
			  			'style'	    => 'text-transform:lowercase'
            );
		echo form_format("Tags: ",form_input($format),'Short, generic words separated by \',\' (commas) example: abortion, lgbt, war' ); 
		?>
		<br />
		<br />
		<?= form_hidden('submitted','true'); ?>
		<?= form_hidden('event_url',$event_url); ?>
		<input type='hidden' name='thumbnail' id='thumbnail' value=''>
		<?= form_submit('','Submit '.ucfirst($event_type),'class="button"'); ?>		
		<br />
		<br />
		</div>
		<small>* required fields</small>
		
	<?= form_close(); ?>
</div>

<? $this->load->view('view_includes/footer.php'); ?>