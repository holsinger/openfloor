<?
$data['red_head'] = 'Events';
?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <? if (!$this->userauth->isAdmin()) { ?>
  	<h3>Convention Next</h3>
  	<p style="margin-left: 10px; margin-right: 30px;"><?=$desc;?></p>
  <? } ?>
  
  <h3>Upcoming Events</h3>	
  
  	<div id="event_view">

	<p><? if ($this->userauth->isAdmin()) echo anchor('/event/create_event','Create an event');?></p>
	<p class='errorArea'><?=(isset($error)?$error:'')?></p>
<<<<<<< .mine
	<? //echo $this->table->generate($events)?>
	<? foreach ($events as $key => $array) {?>
		<div id='event<?=$array['event_id'];?>' class='event-summary'>
		<br /><strong><?=$array['event_name'];?></strong>
		
		<?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?>
		
		<!-- <span style"float:right;"><? //echo $array['event_avatar'];?></span> -->
		<br /><b>When:</b> <?=$array['event_date'];?>
		<br /><b>Where:</b> <?=$array['location'];?>
		<br /><?=$array['event_desc'];?>
		<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
		</div>
=======
	<? //echo $this->table->generate($events)?>
	<? foreach ($events as $key => $array) {?>
		<div id='event<?=$array['event_id'];?>' class='event-summary'>
		<br /><a href='index.php/question/queue/event/<?=url_title($array['event_name']);?>'><strong><?=$array['event_name'];?></strong></a>
		<span style"float:right;"><?=$array['event_avatar'];?></span>
		<br /><b>When:</b> <?=$array['event_date'];?>
		<br /><b>Where:</b> <?=$array['location'];?>
		<br /><b>Description:</b> <?=$array['event_desc'];?>
		<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
		</div>
>>>>>>> .r192
	<? }?>
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>