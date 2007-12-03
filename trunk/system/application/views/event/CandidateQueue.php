<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<base href="<?= $this->config->site_url();?>" />
		<title>view_live_queue</title>
		<meta name="generator" content="TextMate http://macromates.com/">
		<meta name="author" content="Rob Stefanussen">
		<link rel="stylesheet" type="text/css" href="css/all.css" />
		<link rel="stylesheet" type="text/css" href="css/CandidateQueue.css" />
		<script src="./javascript/prototype.js" type="text/javascript"></script>
		<script src="./javascript/scriptaculous.js" type="text/javascript"></script>
		<script type="text/javascript">site_url = '<?= $this->config->site_url();?>';</script>
	</head>
	<body>
			<br />
			<span class='queue-logo'>
				<h1>OpenFloor Events</h1>
			</span>
			<br />
		
			<h3>&nbsp;&nbsp;Current Question:</h3>	
			<div id="current_question" class="current_question">
			</div>
			<h3>&nbsp;&nbsp;Upcoming Questions:</h3>
			<div id="upcoming_questions" class="upcoming_questions">
			</div>
	</body>
</html>
<script type="text/javascript" charset="utf-8">
	new Ajax.PeriodicalUpdater('current_question', site_url + 'forums/candidateQueue/<?=$event_name?>/current_question', {
	  frequency: 10
	});
	//new Effect.Opacity ('upcoming_questions',{duration:.5, from:1.0, to:0.7});
	new Ajax.PeriodicalUpdater('upcoming_questions', site_url + 'forums/candidateQueue/<?=$event_name?>/upcoming_questions', {
	  frequency: 10
	});	
</script>