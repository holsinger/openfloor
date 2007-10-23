<?
if(isset($rss)) $data['rss'] = $rss;
$data['rss'][] = array(	'title' => 'RunPolitics Events Feed', 
						'href' => site_url("feed/events"));
$data['rss'][] = array(	'title' => ucwords(str_replace('_',' ', $event_name)) . ' Event Feed', 
						'href' => site_url("feed/event/$event_name"));
$data['red_head'] = $event_type.'s';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = $event_url;
$data['left_nav'] = 'event';
$tag_execute = '';
if(isset($vars['tag'])) $tag_execute = "tag='{$vars['tag']}';";
?>
<?$this->load->view('view_includes/header.php',$data);?>
<div id="content_div">
	<h3><?=$queue_title;?></h3>
	<div id='queue'>
	<?php if(isset($ajax)) ob_clean();?>
	<? if(!isset($ajax)): ?>
	<img src="<?=base_url();?>/images/nothing.gif" onLoad="offset='<?=$vars['offset']?>';event_name='<?=$vars['event_name']?>';sort='<?=$vars['sort']?>';<?=$tag_execute?>">
	<? endif; ?>
	<? if(!isset($ajax) && $event_type == 'question'): ?>
	<img src="<?=base_url();?>/images/nothing.gif" onLoad="offset='<?=$vars['offset']?>';event_name='<?=$vars['event_name']?>';sort='<?=$vars['sort']?>';">
	<? endif; ?>
	<?
	if ($event_type == 'video')	{
		foreach ($results as $row)
			$this->load->view('view_includes/view_video_pod.php',$row);
	}else{		
		foreach ($results as $row)
			$this->load->view('view_includes/view_question_pod.php',$row);
	}	
	?>
	<p><?=empty($results)?'<strong>There are no '.$event_type.'s to display '.anchor("$event_type/add/$event_url",'Submit A '.ucwords($event_type)).'</strong>':''?>
	<? if(isset($ajax))	ob_end_flush(); ?>
	</div>
</div>
<?
$data['pagination'] = $pagination;
$this->load->view('view_includes/footer.php',$data);
?>