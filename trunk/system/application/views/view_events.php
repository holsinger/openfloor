<!--
	#dependency events.css
--> 
<?
$data['rss'][] = array(	'title' => 'RunPolitics Events Feed', 
						'href' => site_url("feed/events"));
$data['left_nav'] = 'events';
$data['red_head'] = 'Events';
$data['top_banner_text'] = "OPENFLOOR EVENTS";

// THIS IS TEMP CODE FOR AN EVENT AND NEEDS TO BE REPLACED
$data['use_temp_top'] = true;
?>
<? $this->load->view('view_includes/header.php',$data); ?>
<div id="content_div" class="event_content_div">
	<h1> OpenFloor Events</h1>
	<!-- <span style="font-weight: normal; font-family: Arial Black;	font-variant: small-caps; font-size: 25px; font-family: Georgia; color: #033D7C"> OpenFloor Events</span> -->
	<? if($this->userauth->isAdmin()): ?>
		<?="<p>".anchor('/event/create_event','Create an event').(isset($error)?"<br />".$error:'')."</p>"?>
	<? endif; ?>
	<!-- FIRST, LIVE EVENTS -->
	<? $count=0; ?>
	<? foreach ($events as $key => $array): ?>   
		<? if($array['streaming']): ?>
			
			<h3 class="subheader">Live Events</h3>
			<div id="event<?=$array['event_id'];?>" class="event-summary">
            	<table border="0" cellspacing="0" cellpadding="0">
            		<tr>
						<td valign="top" style="padding-right: 3px;">
							<div><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
							<div>
								<?
								$atts = array('width' => '372',	'height' => '280', 'scrollbars' => 'no', 'status' => 'no', 'resizable' => 'no',	'screenx' => '0', 'screeny' => '0');
								?>
								<?=anchor_popup('forums/stream_high/' . url_title($array['event_name']), 'View Live Feed', $atts)?>
							</div>
						</td>
						<td valign="top">
							<span style="display: block; padding-bottom: 5px;"><?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br /></span>	
							<b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
							<b>Where:</b> <?=$array['location'];?><br /><br />
							<b>Description:</b> <?=$array['event_desc_brief'];?>&nbsp;<?= anchor('/event/view/' . url_title($array['event_name']), 'more...') ?><br/>
							<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
						</td>
					</tr>
            	</table>
				<div style="background-color: #0173ba; margin: 5px -6px -10px -6px; padding: 3px 3px 0px 3px; text-align: center"><img src="./images/events/participate_now_button.png" border="0" class="link" onclick="window.open(site_url+'forums/cp/<?=url_title($array['event_name'])?>','dashboard', 'width=1015,height=700,scrollbars=yes,status=no,resizable=yes,screenx=0,screeny=0');" /></div>
            </div>
            <br />
		
			<? $count++; ?>
		<? endif; ?>
	<? endforeach; ?>
	<? if($count < 1): ?>
		<div style="margin-left:10px;margin-right:30px;">
			<?=$cms_text;?>
			<? if ($this->userauth->isSuperAdmin()) echo "<br />".anchor('admin/cms/'.$cms_url, 'edit'); ?>
		</div>
		<br/>
		<br/>
	<? endif; ?>
    <!-- NEXT, UPCOMING EVENTS -->
  	<div id="event_view">
		<? //echo $this->table->generate($events)?>
		<h3 class="subheader" id="upcoming_events_title">Upcoming Events</h3>
		<? $count=0; ?>
        <? foreach ($events as $key => $array): ?>              
        	<? if (strtotime($array['event_date']) > strtotime(date('Y-m-d')) && !($array['streaming']) ): ?>
                <div id="event<?=$array['event_id'];?>" class="event-summary">
                	<div style="float:left; padding: 0px 5px 5px 0px;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
					
					<span style="display: block; padding-bottom: 5px;"><?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br /></span>	
					<b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
					<b>Where:</b> <?=$array['location'];?><br /><br />
					<b>Description:</b> <?=$array['event_desc_brief'];?>&nbsp;<?= anchor('/event/view/' . url_title($array['event_name']), 'more...') ?><br/>
					<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
                </div>
                <br />
           		<?$count ++;
		       endif; ?>
        <? endforeach; ?>
        <? if ($count < 10) : ?>
			<div id="working_town_div">
				<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td style="padding-right: 15px;"><img src="./images/events/upcoming_event_calendar.png" /></td>
						<td valign="middle" align="left" width="100%">We are working hard to bring our OpenFloor Events to your town!  Stay tuned...</td>
					</tr>
				</table>
				<div style="background-color: #0173ba; margin: 5px -10px -10px -10px; padding: 3px 3px 0px 3px; text-align: center"><?=anchor("contact/showForm/request_an_event/","<img src='./images/events/RP_Events_Demand_Event.png' border='0'>");?></div>
			</div>
		<? endif; ?>
		<!-- FINALLY, PAST EVENTS -->
        <br />
        <? //echo $this->table->generate($events)?>
        <h3 class="subheader" id="past_events_title">Past Events</h3>
        <? foreach ($events as $key => $array): ?>
        	<? if (strtotime($array['event_date']) < strtotime(date('Y-m-d'))): ?>
                <div id="event<?=$array['event_id'];?>" class="event-summary">
                	<div style="float:left; padding: 0px 5px 5px 0px;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
					
					<?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br />
					<b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
					<b>Where:</b> <?=$array['location'];?><br /><br />
					<b>Description:</b> <?=$array['event_desc_brief'];?>&nbsp;<?= anchor('/event/view/' . url_title($array['event_name']), 'more...') ?><br />
					<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
                </div>
                <br />
                
           <? endif; ?>
        <? endforeach; ?>
        </div>
		<div style="background-color: #0173ba; text-align: center">
			<?=anchor("contact/showForm/request_an_event/","<img src='./images/events/RP_Events_Demand_Event.png' border='0'>");?>
		</div>

</div>
<? $this->load->view('view_includes/footer.php'); ?>