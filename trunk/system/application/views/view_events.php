<?

$data['rss'][] = array(	'title' => 'RunPolitics Events Feed', 
						'href' => site_url("feed/events"));

$data['left_nav'] = 'events';
$data['red_head'] = 'Events';
?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <!-- <h3>Convention Next</h3> -->
  <div style="margin-left:10px;margin-right:30px;"><?=$cms_text;?></div>
  <? if ($this->userauth->isSuperAdmin()) echo "<div>".anchor('admin/cms/'.$cms_url, 'edit')."</div>"; ?>
  
  <h3>Events</h3>	
  
  	<div id="event_view">

	<p><? if ($this->userauth->isAdmin()) echo anchor('/event/create_event','Create an event');?></p>
	<p class='errorArea'><?=(isset($error)?$error:'')?></p>

	<? //echo $this->table->generate($events)?>
	<h3>&nbsp;&nbsp;&nbsp;&nbsp;Upcoming Events</h3>

        <? foreach ($events as $key => $array) {?>
                <? $count=0; ?>
                <? if (strtotime($array['event_date']) > strtotime(date('Y-m-d'))) { ?>
                <div id='event<?=$array['event_id'];?>' class='event-summary'>
                <div style="float:left;"><?= !empty($array['event_avatar']) ? "<img src=\"./avatars/{$array['event_avatar']}\">" : '' ?></div>
                        <?=anchor('forums/queue/event/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>');?><br />
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
           <?$count ++;
           }?>
        <? }?>
        <? if ($count<1) echo "<center>We are working hard to bring our forums to your town!</center>"; ?>
        <br />
        <? //echo $this->table->generate($events)?>
        <h3>&nbsp;&nbsp;&nbsp;&nbsp;Past Events</h3>
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


</div>

<? $this->load->view('view_includes/footer.php'); ?>