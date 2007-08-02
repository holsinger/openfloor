<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>view_live_queue</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Rob Stefanussen">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/view_live_queue.css" />
	<!-- Date: 2007-08-02 -->
</head>
<body>

<h3>Current Question</h3>	
<? if(!empty($current_question)): ?>	
<p class="current_question">
<? echo $current_question[0]['question_name']; ?>
</p>
<? else: ?>
<p class="no_current_question">There is no current question</p>
<? endif; ?>
<h3>Upcoming Questions:</h3>
<p class="upcoming_questions">
<?	foreach($questions as $question): 
		$votes = ($question['votes'] == 1) ? 'vote' : 'votes' ;
		echo "<p><span class=\"votes\">{$question['votes']} $votes</span>";
		echo "<span class=\"question\">{$question['question_name']}</span></p>";
	endforeach;	?>
</p>

</body>
</html>