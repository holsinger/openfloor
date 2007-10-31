<!--
	#dependency events.css
--> 
<?
if(isset($rss)) $data['rss'] = $rss;
$data['rss'][] = array(	'title' => 'RunPolitics Events Feed', 
						'href' => site_url("feed/events"));
if(!$global)
$data['rss'][] = array(	'title' => ucwords(str_replace('_',' ', $event_name)) . ' Event Feed', 
						'href' => site_url("feed/event/$event_name"));
$data['red_head'] = $event_type.'s';
$data['tabs'] = $event_type;
$data['tab_view_question'] = 'active';
$data['event_url'] = $event_url;
$data['left_nav'] = $global ? 'events' : 'event';
$tag_execute = '';
if(isset($vars['tag'])) $tag_execute = "tag='{$vars['tag']}';";
?>

<?$this->load->view('view_includes/header.php',$data);?>
<div id="content_div">
	<? if(!$global && $event_info['streaming'] ): ?>
		<div id="participate_live_div">
			<div text-align="center">This event is currently open for live participation.  Click on the button below to join.</div>
			<div style="background-color: #0173ba; margin: 10px -6px -6px -6px; padding: 4px 3px 0px 10px; text-align: center"><img src="./images/events/participate_now_button.png" border="0" class="link" onclick="window.open(site_url+'forums/cp/<?=url_title($event_name)?>','dashboard', 'width=1015,height=700,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0');" /></div>
		</div>
	<? endif; ?>
	
	<h3><?=$queue_title;?></h3>
	<div id='queue'>
		<? if(isset($ajax)) ob_clean(); ?>
		<? if(!isset($ajax)): ?>
		<img src="<?=base_url();?>/images/nothing.gif" onLoad="offset='<?=$vars['offset']?>';event_name='<?= $global ? 'none' : $vars['event_name']?>';sort='<?=$vars['sort']?>';<?=$tag_execute?>">
		<? endif; ?>
		<? if(!isset($ajax) && $event_type == 'question'): ?>
		<img src="<?=base_url();?>/images/nothing.gif" onLoad="offset='<?=$vars['offset']?>';event_name='<?= $global ? 'none' : $vars['event_name']?>';sort='<?=$vars['sort']?>';">
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
		<? if(isset($ajax)) ob_end_flush(); ?>
	</div>
</div>
<?
$data['pagination'] = $pagination;
$this->load->view('view_includes/footer.php',$data);
?>