<div class="pots">
	<div class="box">
		
		<div class="inner-box" id="events">
			<span style="padding-left:5px;"><img style="margin-left:-15px" src='./images/RP_OpenFloorEvents.png'>
			 <div id="events_sidebar_div">Loading...</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	new Ajax.Updater("events_sidebar_div", 
					'<?=$this->config->site_url()?>event/GetEventsForSidebar/', 
					{ method: 'get'	}
	);
</script>