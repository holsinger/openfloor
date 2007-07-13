<?
$data['red_head'] = $event_type.'s';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = $event_url;
?>
<?$this->load->view('view_includes/header.php',$data);?>
<div id="content_div">
	<h3><?=$queue_title;?></h3>
	<div id='queue'>
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
	</div>	
</div>
<?$this->load->view('view_includes/footer.php');?>