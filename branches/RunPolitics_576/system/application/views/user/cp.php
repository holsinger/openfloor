<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>myControlPanel</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/all.css" /> -->
	<link rel="stylesheet" type="text/css" href="css/ucp.css" />
	<!-- <link rel="stylesheet" type="text/css" href="css/view_live_queue.css" /> -->
	<script type="text/javascript" src="javascript/lib/prototype.js"></script>
	<script src="javascript/src/scriptaculous.js" type="text/javascript"></script>
	<script type="text/javascript">
	ajaxOn = true;
	site_url = '<?= $this->config->site_url();?>';
	var event_name = '<?=$event?>';
	var cans = [<? $cans = ''; foreach($candidates as $v) $cans .= "'{$v['can_id']}', "; echo substr($cans, 0, -2); ?>];	
	</script>

	<script type="text/javascript" src="javascript/cpUpdater.js"></script>
	<script type="text/javascript">//cpUpdater.cpUpdate();</script>
	<style type="text/css" media="screen" >
		/* put the left rounded edge on the track */
		.track-left {
			position: absolute;
			width: 5px;
			height: 9px;
			background: transparent url(./images/slider-images-track-left.png) no-repeat top left;
		}

		/* put the track and the right rounded edge on the track */
		.track {
			background: transparent url(./images/slider-images-track-right.png) no-repeat top right;
		}
	</style>
</head>
<body>		
	<div id="ucp">
		<h1>Dashboard</h1>
		<div class="hr-1"></div>
		<div class="section">
			<span class="section-title">Current Question</span>
			<img class="content-toggle" src="./images/ucp/toggle.jpg"/>
		</div>
		<div id="current_question" class="current-question-pod">
			<div class="score">14</div>
			<div class="vote">
				<img src="./images/ucp/vote-up.jpg"/>
				<img src="./images/ucp/vote-down.jpg"/>
			</div>
			<div class="question"><? $this->load->view('user/cp_current_question') ?></div>
			<div class="votes">votes</div>
			<div class="comments">comments</div>
		</div>

		<table class="feed-reaction-panel">
			<tr>
				<td>
					<div class="section">
						<span class="section-title">Live Video Feed:</span>
						<img class="content-toggle" src="./images/ucp/toggle.jpg"/>
					</div>
					<img src="./images/ucp/video-placeholder.jpg"/>
				</td>
				<td>
					<div class="section">
						<span class="section-title">Participant Reaction:</span>
						<img class="content-toggle" src="./images/ucp/toggle.jpg"/>
					</div>
					<div id="user-reaction">
						<table>
							<tr><th class="candidate">Candidate</th><th class="reaction">Your Reaction</th></tr>
							<? $class = '' ?>
							<? foreach($candidates as $v): ?>
							<tr<?=$class?>>
								<td><?=$v['can_display_name']?></td>
								<td><div id="your-reaction-<?=$v['can_id']?>"><?$this->load->view('user/_userReactSlider', $v)?></div></td>
							</tr>
							<? $class = $class ? '' : ' class="alternate"' ?>
							<? endforeach; ?>
						</table>							
					</div>
					<br/><br/>
					<img src="./images/ucp/ask-a-question.jpg"/>
				</td>
			</tr>
		</table>
		<div class="section">
			<span class="section-title">Upcoming Questions</span>
			<img class="content-toggle" src="./images/ucp/toggle.jpg"/>
		</div>
		<div id="upcoming_questions">		
			<? $this->load->view('user/cp_upcoming_questions') ?>
		</div>	
	</div>	
</body>
</html>