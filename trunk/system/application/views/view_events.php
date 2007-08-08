<?
$data['red_head'] = 'Events';
?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <!-- <h3>Convention Next</h3> -->
  <div style="margin-left:10px;margin-right:30px;"><?=$cms_text;?></div>
  <? if ($this->userauth->isAdmin()) echo "<div>".anchor('admin/cms/'.$cms_url, 'edit')."</div>"; ?>
  
  <h3>Upcoming Events</h3>	
  
  	<div id="event_view">

	<p><? if ($this->userauth->isAdmin()) echo anchor('/event/create_event','Create an event');?></p>
	<p class='errorArea'><?=(isset($error)?$error:'')?></p>

	<? //echo $this->table->generate($events)?>
	<? foreach ($events as $key => $array) {?>
		<div id='event<?=$array['event_id'];?>' class='event-summary'>
		<div style="float:left;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
			<p><?=anchor('conventionnext/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br />		
			<b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
			<b>Where:</b> <?=$array['location'];?><br />
			<b>Description:</b> <?=$array['event_desc_brief'];?>
			</p>
			<p><strong><?=anchor_popup('information/videoFeed/' . url_title($array['event_name']), 'CLICK HERE FOR LIVE VIDEO', array())?></strong></p>
		</div>
		<br />
		<? if ($this->userauth->isAdmin()) echo $array['edit'];?>

	<? }?>
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>