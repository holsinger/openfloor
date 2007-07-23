<?
$data['red_head'] = 'Events';
?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <h3>Convention Next</h3>
  <div style="margin-left:10px;margin-right:30px;"><?=$cms_text;?></div>
  <? if ($this->userauth->isAdmin()) echo "<div>".anchor('admin/cms/'.$cms_url, 'edit')."</div>"; ?>
  
  <h3>Upcoming Events</h3>	
  
  	<div id="event_view">

	<p><? if ($this->userauth->isAdmin()) echo anchor('/event/create_event','Create an event');?></p>
	<p class='errorArea'><?=(isset($error)?$error:'')?></p>

	<? //echo $this->table->generate($events)?>
	<? foreach ($events as $key => $array) {?>
		<div id='event<?=$array['event_id'];?>' class='event-summary'>
		<br /><?=anchor('conventionnext/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?>
		<span style"float:right;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></span>
		<br /><b>When:</b> <?=$array['event_date'];?>
		<br /><b>Where:</b> <?=$array['location'];?>
		<br /><b>Description:</b> <?=$array['event_desc'];?>
		<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
		</div>

	<? }?>
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>