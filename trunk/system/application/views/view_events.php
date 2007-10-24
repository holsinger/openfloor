<?

$data['rss'][] = array(	'title' => 'RunPolitics Events Feed', 
						'href' => site_url("feed/events"));

$data['left_nav'] = 'events';
$data['red_head'] = 'Events';
$data['top_banner_text'] = "OPENFLOOR EVENTS";
?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
	<? if($this->userauth->isAdmin()): ?>
		<?="<p>".anchor('/event/create_event','Create an event').(isset($error)?"<br />".$error:'')."</p>"?>
	<? endif; ?>
	<img src="images/RP_OpenFloorEvents.png"/>
	<div style="margin-left:10px;margin-right:30px;">
		<div style="float: left; margin: 0px 5px 5px 0px;">
			<div><img src="./images/events/event_example.jpg" border="0" /></div>
			<h1>A new kind of meeting place.</h1>
		</div>
		<?=$cms_text;?>
		<? if ($this->userauth->isSuperAdmin()) echo "<br />".anchor('admin/cms/'.$cms_url, 'edit'); ?>
	</div>
  
  	<div id="event_view">
		<? //echo $this->table->generate($events)?>
		<h3 class="subheader">Upcoming Events</h3>
		<? $count=0; ?>
        <? foreach ($events as $key => $array) {?>
                
                <? if (strtotime($array['event_date']) > strtotime(date('Y-m-d'))) { ?>
                <div id="event<?=$array['event_id'];?>" class="event-summary">
                	<div style="float:left; padding: 0px 5px 5px 0px;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
					
					<span style="display: block; padding-bottom: 5px;"><?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br /></span>	
					<b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
					<b>Where:</b> <?=$array['location'];?><br /><br />
					<b>Description:</b> <?=$array['event_desc_brief'];?>&nbsp;<?= anchor('/event/view/' . url_title($array['event_name']), 'more...') ?><br/>
					<?if($array['streaming']):?>
						<?
						$atts = array(
						'width'      => '372',
						'height'     => '280',
						'scrollbars' => 'no',
						'status'     => 'no',
						'resizable'  => 'no',
						'screenx'    => '0',
						'screeny'    => '0'
						);
						?>
						<p><strong><?=anchor_popup('forums/stream_high/' . url_title($array['event_name']), 'CLICK HERE FOR LIVE VIDEO', $atts)?></strong></p>
					<?endif;?>
					<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
                </div>
                <br />
                
           <?$count ++;
           }?>
        <? }?>
        <? 
		if ($count < 0) {
			// Ugly table used for vertical text alignment
			echo '
			<div id="working_town_div">
				<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td style="padding-right: 15px;"><img src="./images/events/upcoming_event_calendar.png" /></td>
						<td valign="middle" align="left" width="100%">We are working hard to bring our OpenFloor Events to your town!  Stay tuned...</td>
					</tr>
				</table>
			</div>'; 
		}
		?>
        <br />
        <? //echo $this->table->generate($events)?>
        <h3 class="subheader">Past Events</h3>
        <? foreach ($events as $key => $array) {?>
                <? if (strtotime($array['event_date']) < strtotime(date('Y-m-d'))) { ?>
                <div id="event<?=$array['event_id'];?>" class="event-summary">
                	<div style="float:left; padding: 0px 5px 5px 0px;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
					
					<?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br />
					<b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
					<b>Where:</b> <?=$array['location'];?><br />
					<b>Description:</b> <?=$array['event_desc_brief'];?><br/>
					<?= anchor('/event/view/' . url_title($array['event_name']), 'more...') ?><br />

                        
					<?if($array['streaming']):?>
						<?
						$atts = array(
						'width'      => '372',
						'height'     => '280',
						'scrollbars' => 'no',
						'status'     => 'no',
						'resizable'  => 'no',
						'screenx'    => '0',
						'screeny'    => '0'
						);
						?>
						<p><strong><?=anchor_popup('forums/stream_high/' . url_title($array['event_name']), 'CLICK HERE FOR LIVE VIDEO', $atts)?></strong></p>
					<?endif;?>
					<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
                </div>
                <br />
                
           <? }?>
        <? }?>
        </div>
		<div style="text-align: center">
			<img src="./images/events/RP_Events_Demand_Event.png" border="0" class="link" onclick="window.location=site_url+'contact/showForm/request_an_event';">
		</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>