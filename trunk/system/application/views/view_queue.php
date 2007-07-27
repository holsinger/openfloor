<?
$data['red_head'] = $event_type.'s';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = $event_url;
?>
<?$this->load->view('view_includes/header.php',$data);?>
<div id="content_div">
	<h3><?=$queue_title;?></h3>
	<? if(isset($ajax)) ob_clean();?>
	<div id='queue'>
	<? if(!isset($ajax)): ?>
	<img src="<?=base_url();?>/images/nothing.gif" onLoad="event_name='<?=$vars['event_name']?>';sort='<?=$vars['sort']?>';queueUpdater.updateQueue();">
	<? endif; ?>
	<?
	if ($event_type == 'video')
	{
		foreach ($results as $row)
			$this->load->view('view_includes/view_video_pod.php',$row);
	}
	else 
	{		
		foreach ($results as $row)
		$this->load->view('view_includes/view_question_pod.php',$row);
	}	
	?>
	<p><?=empty($results)?'There are no questions to display':''?>
	<p><?=(!empty($results))?$this->pagination->create_links():''?></p>
	<p><?=(isset($cloud))?$cloud:''?></p>
	</div>
	<? if(isset($ajax))	ob_end_flush(); ?>
</div>
<?$this->load->view('view_includes/footer.php');?>