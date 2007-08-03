<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?= $this->config->site_url();?>" />
	<title>view_live_queue</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Rob Stefanussen">
	<link rel="stylesheet" type="text/css" href="css/view_live_queue.css" />
	<script type="text/javascript" src="javascript/lib/prototype.js"></script>
	<script type="text/javascript">site_url = '<?= $this->config->site_url();?>';var event_name = '<?=$event?>';</script>
	<script type="text/javascript" src="javascript/liveQueueUpdater.js"></script>
	<script type="text/javascript">liveQueueUpdater.liveQueueUpdate();</script>
	<!-- Date: 2007-08-02 -->
</head>
<body>

<h3>Current Question</h3>	
<? if(!empty($current_question)): ?>	
<div id="current_question" class="current_question"><p>
<? echo $current_question[0]['question_name']; ?>
</p></div>
<? else: ?>
<div class="no_current_question"><p>There is no current question</p></div>
<? endif; ?>
<h3>Upcoming Questions:</h3>
<div id="upcoming_questions" class="upcoming_questions">
<?	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote' : 'votes' ;
		echo "<p><span class=\"votes\">{$question['votes']} $votes</span>";
		echo "<span class=\"question\">{$question['question_name']}</span></p>";
	endforeach;	?>
</div>

</body>
</html>