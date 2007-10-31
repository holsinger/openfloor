<div class="pots">
	<div class="box">
		
		<div class="inner-box" id="events">
			<span style="font-weight: normal; font-family: Arial Black;	font-variant: small-caps; font-size: 25px; font-family: Georgia; color: #033D7C"> OpenFloor Events</span>
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