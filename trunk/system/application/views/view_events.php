<?

$data['rss'][] = array(	'title' => 'RunPolitics Events Feed', 
						'href' => site_url("feed/events"));

$data['left_nav'] = 'events';
$data['red_head'] = 'Events';
$data['top_banner_text'] = "OPENFLOOR EVENTS";
?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
   <br/>
  <img src="images/RP_OpenFloorEvents.png"/>
  <div style="margin-left:10px;margin-right:30px;"><?=$cms_text;?></div>
  <? if ($this->userauth->isSuperAdmin()) echo "<div>".anchor('admin/cms/'.$cms_url, 'edit')."</div>"; ?>
    
  	<div id="event_view">
		<p><? if ($this->userauth->isAdmin()) echo anchor('/event/create_event','Create an event');?></p>
		<p class='errorArea'><?=(isset($error)?$error:'')?></p>

		<? //echo $this->table->generate($events)?>
		<h3 class="subheader"  >Upcoming Events</h3>
		<? $count=0; ?>
        <? foreach ($events as $key => $array) {?>
                
                <? if (strtotime($array['event_date']) > strtotime(date('Y-m-d'))) { ?>
                <div id='event<?=$array['event_id'];?>' class='event-summary'>
                	<div style="float:left;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
					<?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br />
					<b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
					<b>Where:</b> <?=$array['location'];?><br /><br />
					<b>Description:</b> <?=$array['event_desc_brief'];?>&nbsp;<?= anchor('/event/view/' . url_title($array['event_name']), 'more...') ?><br/>


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
					<?if($array['streaming']):?>
					<p><strong><?=anchor_popup('forums/stream_high/' . url_title($array['event_name']), 'CLICK HERE FOR LIVE VIDEO', $atts)?></strong></p>
					<?endif;?>
                </div>
                <br />
                <? if ($this->userauth->isAdmin()) echo $array['edit'];?>
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
                <div id='event<?=$array['event_id'];?>' class='event-summary'>
                <div style="float:left;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
                        <?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br />       -
                        <b>When:</b> <?=date("F j, Y, g:i a", strtotime($array['event_date']));?><br />
                        <b>Where:</b> <?=$array['location'];?><br />
                        <b>Description:</b> <?=$array['event_desc_brief'];?><br/>
                        <?= anchor('/event/view/' . url_title($array['event_name']), 'more...') ?>

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
                        <?if($array['streaming']):?>
                        <p><strong><?=anchor_popup('forums/stream_high/' . url_title($array['event_name']), 'CLICK HERE FOR LIVE VIDEO', $atts)?></strong></p>
                        <?endif;?>
                </div>
                <br />
                <? if ($this->userauth->isAdmin()) echo $array['edit'];?>
           <? }?>
        <? }?>
        </div>
		<div style="text-align: center">
			<img src="./images/events/RP_Events_Demand_Event.png" border="0" class="link" onclick="window.location=site_url+'contact/showForm/request_an_event';">
		</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>