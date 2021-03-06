<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>myControlPanel</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/all2.css" /> -->
	<link rel="stylesheet" type="text/css" href="css/overall_reaction.css" />
	<script src="./javascript/prototype.js" type="text/javascript"></script>
	<script src="./javascript/scriptaculous.js" type="text/javascript"></script>
	<script type="text/javascript">
	ajaxOn = true;
	site_url = '<?= $this->config->site_url();?>';
	var event_name = '<?=$event?>';
	var cans = [<? $cans = ''; foreach($candidates as $v) $cans .= "'{$v['user_id']}', "; echo substr($cans, 0, -2); ?>];	
	</script>
	<script type="text/javascript" src="javascript/orUpdater.js"></script>
	<script type="text/javascript">orUpdater.orUpdate();</script>
	</script>
</head>
<body>
	<div id="ucp">
		<h1>Event Overall Reaction</h1>
		<table class="feed-reaction-panel">
			<tr>
				<td>
					<div class="section">
						<span class="section-title">Live Video Feed:</span>
						<img class="content-toggle" src="./images/ucp/toggle.jpg" onClick="javascript:new Effect.toggle('video_container','blind', {queue: 'end'});"/>
					</div>
					<div id="video_container">
						<?= $stream_high ?>
						<!-- <img src="./images/ucp/video-placeholder.jpg"/> -->
					</div>
				</td>
				<td>
					<div class="section">
						<span class="section-title">Overall Reaction:</span>
						<img class="content-toggle" src="./images/ucp/toggle.jpg" onClick="javascript:new Effect.toggle('overall-reaction','blind', {queue: 'end'});"/>
					</div>
					<div id="overall-reaction">
						<table>
							<span class="sectionSmall">Candidate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Overall Reaction:</span>		
							<? $class = '' ?>
							<? foreach($candidates as $v): ?>
							<tr<?=$class?>>
								<td><?=$v['display_name']?></td>
								<td>
									<div id="overall-reaction-<?=$v['user_id']?>">
										<div class="overall-reaction-meter-total"><div class="overall-reaction-meter" style="width: <?=$v['overall_reaction']?>; height: 15px"></div></div>
									</div>
								</td>
							</tr>
							<? $class = $class ? '' : ' class="alternate"' ?>
							<? endforeach; ?>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>