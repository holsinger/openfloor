<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>view_live_queue</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Rob Stefanussen">
	<link rel="stylesheet" type="text/css" href="css/all.css" /><link rel="stylesheet" type="text/css" href="css/view_live_queue.css" />
	<script src="./javascript/prototype.js" type="text/javascript"></script>
	<script src="./javascript/scriptaculous.js" type="text/javascript"></script>
	<script type="text/javascript">site_url = '<?= $this->config->site_url();?>';var event_name = '<?=$event?>';</script>
	<script type="text/javascript" src="javascript/textsizer.js"></script>

<script type="text/javascript" src="javascript/liveQueueUpdater.js"></script>
	<script type="text/javascript">liveQueueUpdater.liveQueueUpdate();</script>
	<!-- Date: 2007-08-02 -->
</head>
<body>
		<br />
		<span class='queue-logo'>
			<!-- <img src="./images/bg-convention-next.gif" alt="convention-next"/> -->
			<h1>OpenFloor Events</h1>
			<a href="javascript:ts('body',1)" class="invisi">[+]</a><a href="javascript:ts('body',-1)" class="invisi">[-]</a>
		</span>
		<!-- <span class="participants"><?=$this->db->count_all('ci_sessions')?> Participants</span> -->
		<br />
		<ul class="top-nav"></ul>
		
		<h3> &nbsp;&nbsp;Current Question: <?//=$timerHTML?></h3>	
		<div id="current_question" class="current_question">
		<? echo (!empty($current_question)) ? $current_question[0]['question_name']:'There is no current question'; ?>
		</div>
		<h3> &nbsp;&nbsp;Upcoming Questions:</h3>
		<div id="upcoming_questions" class="upcoming_questions">
		<?	foreach($questions as $question): 
				$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ;
				echo "<div class='queue-question'><span class=\"votes\">{$question['votes']} $votes</span>";
				echo "<span class=\"question\">{$question['question_name']}</span></div><br />";
			endforeach;	?>
		</div>
</body>
</html>